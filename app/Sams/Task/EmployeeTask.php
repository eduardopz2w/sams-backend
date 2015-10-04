<?php

namespace Sams\Task;

use Sams\Manager\ImageEmployeeManager;
use Sams\Repository\EmployeeRepository;

class EmployeeTask extends BaseTask {

	protected $employeeRepo;

	public function __construct(EmployeeRepository $employeeRepo) {
	  $this->employeeRepo = $employeeRepo;
	}

	public function getEmployees() {
		$employees = $this->employeeRepo->getEmployees();

		if ($employees->count() == 0) {
			$message = 'No hay empleados registrados';

			$this->hasException($message);
		}

		return $employees;
	}

  public function addImg($employee, $img, $mime) {
	  $imgRecord = new ImageEmployeeManager($employee, $img, $mime);

	  $imgRecord->uploadImg();
  }
	
	public function format($employee) {
		$employee = [
			'identity_card' => $employee->identity_card,
		  'full_name' => $employee->full_name,
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
}