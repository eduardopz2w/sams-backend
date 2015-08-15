<?php

namespace Sams\Task;

class EmployeeTask extends BaseTask {

	public function employeeActiviti($employee)

	{
			if (!$employee->activiti)

			{
				  $message = 'Empleado fuera de nomina';
				  $this->hasException($message);
			}
	}

	public function employeeNotFound($employee)

	{
			if (!$employee)

			{
					$message = 'Error en la asignacion de empleado';
					$this->hasException($message);
			}
	}


}