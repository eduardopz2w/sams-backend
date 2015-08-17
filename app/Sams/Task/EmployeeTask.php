<?php

namespace Sams\Task;

use Sams\Repository\EmployeeRepository;

class EmployeeTask extends BaseTask {

	protected $elderRepo;

	public function __construct(EmployeeRepository $employeeRepo)

	{
			$this->employeeRepo = $employeeRepo;
	}

	public function findEmployeeById($id)

	{
			$employee = $this->employeeRepo->find($id);
			$this->employeeActiviti($employee);
			
			return $employee;
	}

	public function findEmployeeByCredentials($identityCard)

	{
			$employee = $this->employeeRepo->employeeByIdentify($identityCard);
			
			if ($employee->count() == 0)

			{
					$message = 'Empleado no encontrado, verifique e intente de nuevo';
					$this->hasException($message);
			}

			$employee = $employee->first();
			$this->employeeActiviti($employee);

			return $employee;
	}

	public function employeeActiviti($employee)

	{
			if (!$employee->activiti)

			{
				  $message = 'Empleado no activo';
				  $this->hasException($message);
			}
	}
}