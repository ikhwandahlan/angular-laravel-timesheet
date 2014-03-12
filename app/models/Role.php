<?php
class Role extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';
	protected $primaryKey = 'role_id';
	public $timestamps = FALSE;

	public function users() {

		return $this->belongsToMany('User', 'user_id');
	}

	public static function getDefaultUser() {

		return self::where('role_name', '=', Config::get('timesheet.default_user_role'))->first()->role_id;
	}

	public static function getDefaultAdmin() {

		return self::where('role_name', '=', Config::get('timesheet.min_admin_role'))->first()->role_id;

	}
}