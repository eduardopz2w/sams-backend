<?php

namespace Sams\Task;

use Sams\Manager\ValidationException;

class ElderTask {

	public function elderActiviti($elder)

	{
			if (!$elder->activiti)

			{
					throw new ValidationException("Error Processing Request", "Adulto mayor no esta en nomina");
			}

	}

}