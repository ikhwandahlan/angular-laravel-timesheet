<?php
class AdminController extends BaseController {
	protected $layout = 'layouts.default';
	protected $scope = 'admin';

	public function __construct() {

		$this->beforeFilter('auth');
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));

	}

	/*
	|--------------------------------------------------------------------------
	| Default App Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'AppController@start');
	|
	*/

	public function start() {

		$this->layout->content = View::make('admin');
	}

}