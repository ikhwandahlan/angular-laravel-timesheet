<?php
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		Eloquent::unguard();

		$this->call('RolesTableSeeder');
		$this->call('UserTableSeeder');
	}

}
class UserTableSeeder extends Seeder {
	public function run() {

		DB::table('users')->delete();

		$user = User::create(
					[
							'username' => 'admin',
							'name'     => 'Jervant Malajan',
							'password' => Hash::make('kerberos'),
							'email'    => 'j.malakjan@gmail.com'
					]
		);

		$user->roles()->sync([Role::getDefaultAdmin()]);

		$user->rate()->create(
			 [
					 'rate' => 70
			 ]
		);
	}
}
class RolesTableSeeder extends Seeder {
	public function run() {

		DB::table('roles')->delete();

		Role::create(
			[
					'role_name' => 'Super Admin',
			]
		);

		Role::create(
			[
					'role_name' => 'Admin',
			]
		);

		Role::create(
			[
					'role_name' => 'User',
			]
		);
	}
}