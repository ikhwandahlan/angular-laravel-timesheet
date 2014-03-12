<?php

use Services\Validators\User as UserValidation;

class Admin extends Eloquent {
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

	public static function addUser() {

		try {

			$password = str_random(8);

			$user           = new User();
			$user->name     = 'jméno';
			$user->username = 'username_' . str_random(5);
			$user->email    = str_random(5) . '@email.com';
			$user->save();

			$user->rate()->create(['rate' => 70]);

			$user->roles()->sync([Role::getDefaultUser()]);

			$user = User::with(
						[
								'roles',
								'rate' => function ($query) {

											$query->first();
										}
						]
			)->get()->last();

			$user->message = 'Uživatel přidán. | Heslo: ' . $password;

			return $user;

		}
		catch (Exception $e) {
			switch ($e->getCode()):
				case 23000:
					return Response::make(['message' => ['Email nebo uživatelské jméno již existuje.']], 409);
					break;
				default:
					return Response::make(['message' => ['Chyba při přidání uživatele.']], 500);
			endswitch;

		}
	}

	public static function getUser($userId) {

		try {

			return User::with(
					   array(
							   'roles',
							   'attendance' => function ($query) {

										   $query->orderBy('date_from', 'desc');
									   },
							   'rate'       => function ($query) {

										   $query->first();
									   }
					   ))->findOrFail($userId);
		}
		catch (Exception $e) {

			return Response::make(['message' => ['Uživatel neexistuje.']], 500);
		}
	}

	public static function updateUser($userId) {

		try {

			$user = User::findOrFail($userId);

			UserValidation::$rules['email']    = 'required|email|max:150|unique:users,email,' . $user->user_id . ',user_id';
			UserValidation::$rules['username'] = 'required|alpha_dash|max:50|unique:users,username,' . $user->user_id . ',user_id';

			$validator = new UserValidation();

			if ($validator->passes()) :
				$user->name     = Input::get('name');
				$user->username = Input::get('username');
				$user->email    = Input::get('email');

				if (Input::get('password')):
					$user->password = Hash::make(Input::get('password'));
				endif;

				$user->save();

				foreach (Input::get('roles') as $role):
					$roles[] = $role['role_id'];
				endforeach;

				$user->roles()->sync($roles);

				if ($user->getRate() !== Input::get('rate')):
					$user->rate()->create(['rate' => Input::get('rate')]);
				endif;

				return Response::make(['message' => 'Uživatel aktualizován.']);

			endif;

			return Response::make(['message' => $validator->errors], 400);
		}
		catch (Exception $e) {
			return Response::make(['message' => ['Chypa při aktualizaci uživatele.' . $e->getMessage()]], 500);
		}
	}

	public static function removeUser($userId) {

		try {
			$user = User::find($userId);

			if (!$user->checkAdmin()):
				User::find($userId)->delete();

				return Response::make(['message' => 'Uživatel vymazán.']);
			endif;

			return Response::make(['message' => ['Nelze vymazat administratora.']], 500);
		}
		catch (Exception $e) {
			return Response::make(['message' => ['Chypa při odstranění uživatele.' . $e->getMessage()]], 500);
		}
	}

}