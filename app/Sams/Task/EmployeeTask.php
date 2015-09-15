<?php

namespace Sams\Task;

use Sams\Manager\ImageEmployeeManager;
use Sams\Repository\EmployeeRepository;

class EmployeeTask extends BaseTask {

	protected $employeeRepo;

	public function __construct(EmployeeRepository $employeeRepo) {
	  $this->employeeRepo = $employeeRepo;
	}

	public function getEmployees($state) {
		$employees = $this->employeeRepo->getEmployeesForState($state);

		if ($employees->count() == 0) {
			$message = 'No hay empleado para esta categoria';

			$this->hasException($message);
		}

		$employees = $employees->get();

		return $employees;
	}

  public function addImg($record, $img, $mime) {
	  $imgRecord = new ImageEmployeeManager($record, $img, $mime);

	  $imgRecord->uploadImg();
  }
	
	public function format($employee) {
		$employee = [
			'identity_card' => $employee->identity_card,
		  'first_name' => $employee->first_name,
		  'last_name' => $employee->last_name,
		  'date_birth' => $employee->date_birth,
		  'phone' => $employee->phone,
		  'address' => $employee->address,
		  'gender' => $employee->gender,
		  'degree_instruction' => \Lang::get('utils.degree_instruction.'.$employee->degree_instruction),
		  'civil_status' => \Lang::get('utils.civil_status.'.$employee->civil_status),
		  'office' => $employee->office,
		  'break_out' => $employee->break_out,
		  'image_url' => $employee->image_url,
		  'activiti' => $employee->activiti
		];

		return $employee;
	}

	// public function findEmployeeById($id)

	// {
	//   $employee = $this->employeeRepo->find($id);
	//   $this->employeeActiviti($employee);
			
	//   return $employee;
	// }

	// public function findEmployeeByCredentials($identityCard)

	// {
	//   $employee = $this->employeeRepo->employeeByIdentify($identityCard);
			
	//   if ($employee->count() == 0)

	// 	{
	// 	  $message = 'Empleado no encontrado, verifique e intente de nuevo';
	// 	  $this->hasException($message);
	// 	}

	// 	$employee = $employee->first();
	// 	$this->employeeActiviti($employee);

	// 	return $employee;
	// }

	// public function employeeActiviti($employee)

	// {
	//   if (!$employee->activiti)

	// 	{
	// 	  $message = 'Empleado no activo';
	// 	  $this->hasException($message);
	// 	}
	// }
}