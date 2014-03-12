<?php
class UserController extends BaseController {
	public function __construct() {

		$this->beforeFilter('auth.basic');
		$this->beforeFilter('admin');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		return User::with(
				   [
						   'roles',
						   'rate'
				   ]
		)->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {

		return Admin::addUser();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($userId) {
		return Admin::getUser($userId);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update($userId) {


		return Admin::updateUser($userId);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($userId) {

		return Admin::removeUser($userId);
	}

	public function missingMethod($parameters = array()) {

		return App::abort(404);
	}

}