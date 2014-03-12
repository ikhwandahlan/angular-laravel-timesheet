<?php
class AttendanceController extends BaseController {
	private $user;

	public function __construct() {

		$this->beforeFilter('auth.basic');
		$this->user = Auth::user();

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		return $this->user->getAttendances();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {

		return $this->user->addAttendance();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($attendenceId) {

		return $this->user->getAttendance($attendenceId);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update($attendenceId) {

		return $this->user->updateAttendance($attendenceId);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($attendenceId) {

		return $this->user->removeAttendence($attendenceId);
	}

	public function getMonthPayment($userId = FALSE){
		if(!$userId) $userId = Auth::user()->user_id;

		return Attendance::getMonthPayment($userId);
	}

	public function missingMethod($parameters = array()) {

		return App::abort(404);
	}

}