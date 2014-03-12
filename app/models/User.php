<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $primaryKey = 'user_id';
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier() {

		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {

		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail() {

		return $this->email;
	}

	public function roles() {

		return $this->belongsToMany('Role', 'role_user');
	}

	public function checkAdmin() {

		return $this->roles()->wherePivot('role_id', '<=', Role::getDefaultAdmin())->first();
	}

	/**
	 * Set user -> attendance relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function attendance() {

		return $this->hasMany('Attendance');
	}

	public function payments() {

		return $this->hasMany('Payment');
	}

	/**
	 * Set user -> rate relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function rate() {

		return $this->hasMany('Rate')->orderBy('rate_id', 'desc');
	}

	/**
	 * Get all user attendances
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getAttendances() {

		return $this->attendance()->select(DB::raw("rate,attendance_id, unix_timestamp(date_from) * 1000 as date_from, unix_timestamp(date_to) * 1000 as date_to, DATE_FORMAT(date_from, '%Y-%m-%d') as date"))->orderBy('date_from', 'desc')->get();

	}

	/**
	 * Get one user attendance
	 *
	 * @param $attendenceId
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getAttendance($attendenceId) {

		return $this->attendance()->findOrFail($attendenceId)->get();

	}

	/**
	 * Add attendance
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function addAttendance() {

		if ($this->checkAttendanceToday()):

			try {

				$payment = Payment::createPayment($this->user_id, date('Y-m'));

				$this->attendance()->create(
					 [
							 'rate'       => $this->getRate(),
							 'date_from'  => date('Y-m-d H:i'),
							 'date_to'    => date('Y-m-d H:i'),
							 'payment_id' => $payment->payment_id
					 ]
				);
				$attendence          = $this->lastAttendance();
				$attendence->message = 'Docházka zevidována.';

				$payment->calculate();
				//Payment::findOrFail($attendence->payment_id)->calculate();

				return Response::make($attendence);

			}
			catch (Exception $e) {
				return Response::make(['message' => ['Chyba při přidání docházky.' . $e->getMessage()]], 500);
			}

		endif;

		return Response::make(['message' => ['Docházka pro tento den již existuje.']], 409);

	}

	/**
	 *Update attendance
	 *
	 * @param string $attendanceId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateAttendance($attendanceId) {

		try {

			Services\Validators\Attendance::$rules['date_to'] = 'after:' . Input::get('date_from');

			$validator = new Services\Validators\Attendance();

			if ($validator->passes()) :

				if (!Auth::user()->checkAdmin()):
					$last = $this->lastAttendance();
					if ($attendanceId != $last->attendance_id):
						return Response::make(['message' => ['Docházku se nepodařilo aktualizovat.']], 500);
					endif;
				endif;

				$attendence = Auth::user()->checkAdmin() ? Attendance::findOrFail($attendanceId) : $this->attendance()->find($attendanceId);

				$attendence->date_from = Input::get('date_from');
				$attendence->date_to   = Input::get('date_to');
				$attendence->save();

				Payment::findOrFail($attendence->payment_id)->calculate();

				return Response::make(['message' => 'Docházka aktualizována.']);
			endif;

			return Response::make(['message' => $validator->errors], 400);
		}
		catch (Exception $e) {
			return Response::make(['exists' => ['Docházku se nepodařilo aktualizovat.']], 500);
		}
	}

	/**
	 *Remove attendance
	 *
	 * @param string $attendanceId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function removeAttendence($attendanceId) {

		try {
			$attendence = $this->attendance()->find($attendanceId);
			$paymentId = $attendence->payment_id;
			$attendence->delete();

			Payment::findOrFail($paymentId)->calculate();

			return Response::make(['message' => 'Docházka vymazána.']);
		}
		catch (Exception $e) {
			return Response::make(['message' => ['Docházku se nepodařilo odstranit.']], 500);
		}
	}

	/**
	 * Check if attendance for today exists
	 *
	 * @return bool
	 */
	public function checkAttendanceToday() {

		return $this->attendance()->whereRaw('date_from >= CURRENT_DATE')->count() == 0;
	}

	/**
	 * Get last attendance
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function lastAttendance() {

		return $this->attendance()->select(DB::raw("rate, attendance_id, unix_timestamp(date_from) * 1000 as date_from, unix_timestamp(date_to) * 1000 as date_to, DATE_FORMAT(date_from, '%Y-%m-%d') as date"))->get()->last();
	}

	/**
	 * Get last rate for user
	 *
	 * @return decimal
	 */
	public function getRate() {

		return $this->rate->first()->rate;
	}
}