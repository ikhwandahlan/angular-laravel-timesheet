<?php
class Rate extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rates';
	protected $primaryKey = 'rate_id';

	public function user() {

		return $this->belongsTo('User', 'user_id');
	}

}