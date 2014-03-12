<?php
class Attendance extends Eloquent {
	protected $table = 'attendance';
	protected $primaryKey = 'attendance_id';

	/**
	 * Set attendance -> user relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {

		return $this->belongsTo('User');
	}

	public function payment() {

		return $this->belongsTo('Payment', 'payment_id');
	}

	public static function getMonths($userId) {

		return self::select(DB::raw('DATE_FORMAT(date_from, "%Y-%m") as month'))->where('user_id', '=', $userId)->groupBy('month')->get();
	}

	public function calculateDayPayment() {

		$timeDiff = abs(strtotime($this->date_to) - strtotime($this->date_from));
		$timeDiff = $timeDiff / 60 / 60;
		$payment  = $timeDiff * $this->rate;

		return ['amount' => number_format($payment, 2, '.', ''), 'hours' => number_format($timeDiff, 2, '.', '')];
	}

}