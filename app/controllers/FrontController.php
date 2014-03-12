<?php
class FrontController extends BaseController {
	protected $layout = 'layouts.default';

	public function __construct() {

		$this->beforeFilter('auth', ['except' => ['login', 'loginDo']]);

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

		$this->layout->content = View::make('user');
	}

	public function login() {

		$this->layout->class = 'login-page';
		$this->layout->content = View::make('login');
	}

	public function loginDo() {

		if (Auth::attempt(Input::only(array('username', 'password')), Input::get('remember', FALSE))):
			if (Auth::user()->checkAdmin()) return Response::make('admin');

			return Response::make('');
		endif;

		return Response::make(['message' => ['Špatné přihlašévací údaje.']], 401);

	}

	public function logout() {

		Auth::logout();

		return Redirect::to('');
	}

}