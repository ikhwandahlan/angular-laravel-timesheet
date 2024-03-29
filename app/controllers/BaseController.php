<?php
class BaseController extends Controller {
	protected $scope = 'user';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {

		if (!is_null($this->layout)) {
			$this->layout        = View::make($this->layout);
			$this->layout->scope = $this->scope;
		}

		View::share('scope', $this->scope);
	}

}