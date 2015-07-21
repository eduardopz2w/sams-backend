<?php

namespace Sams\Task;

use Sams\Manager\ValidationException;

class EmployeeTask {

	public function employeeActiviti($employee)

	{
			if (!$employee->activiti)

			{
					throw new ValidationException("Error Processing Request", 'Empleado fuera de servicio');
			}
	}

}