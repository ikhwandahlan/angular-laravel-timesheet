<?php
class Payment extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payments';
	protected $primaryKey = 'payment_id';

	public function user() {

		return $this->belongsTo('User', 'user_id');
	}

	public function attendance() {

		return $this->hasMany('Attendance', 'payment_id');
	}

	public static function getPayments($userId) {

		return Payment::where('user_id', '=', $userId)->get();
	}

	public static function createPayment($userId, $date) {

		try {
			$payment = self::where('user_id', '=', $userId)
						   ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), '=', $date)->firstOrFail();
		}
		catch (Exception $e) {
			$payment          = new self();
			$payment->user_id = $userId;
			$payment->save();
		}

		return $payment;
	}

	public function calculate() {

		$attendences = $this->attendance;

		$this->amount = 0;
		$this->days   = 0;
		$this->hours  = 0;

		foreach ($attendences as $attendence):
			$calculation = $attendence->calculateDayPayment();

			$this->amount += $calculation['amount'];
			$this->days += 1;
			$this->hours += $calculation['hours'];
		endforeach;

		$this->save();
	}

}