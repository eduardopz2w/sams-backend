<?php

use Sams\Manager\ValidationException;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {
		if ( ! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}
	
	public function notFound($value) {
	  if (!$value) {
	  	$this->abort();
	  }
	}

	public function notFoundPivot($pivot) {
		if ($pivot->count() == 0) {
			$this->abort();
		}
	}

	public function abort() {
	  App::abort(404);
	}

	
	

}
