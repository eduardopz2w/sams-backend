<?php

use Sams\Manager\EmployeeManager;
use Sams\Repository\EmployeeRepository;

class EmployeeController extends BaseController {
   
	 protected $employeeRepository;

	 public function __construct(EmployeeRepository $employeeRepository)

	 {
	 		$this->employeeRepository = $employeeRepository;
	 }

   public function createEmployee()

   {
   		$employee = $this->employeeRepository->getModel();

   		$manager = new EmployeeManager($employee, Input::all());
   		$idEmployee = $manager->confirmEmployee();

   		return Response::json(['status'  => 'success',
   			                     'id'      => $idEmployee]);
   }

}