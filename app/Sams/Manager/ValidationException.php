<?php

namespace Sams\Manager;

class ValidationException extends \Exception {

	protected $errors;
	protected $message;

	public function __construct($message, $errors)

	{
			$this->errors = $errors;

			parent::__construct($message);
	}// coment
 
	public function getErrors()

	{
			return $this->errors;
	}
}