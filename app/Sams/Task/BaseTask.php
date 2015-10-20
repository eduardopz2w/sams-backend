<?php

namespace Sams\Task;

use Sams\Manager\ValidationException;

abstract class BaseTask {

	public function hasException($message) {
    throw new ValidationException("Error Processing Request", $message);
  }
}