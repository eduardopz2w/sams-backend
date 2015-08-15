<?php

use Sams\Manager\PermitsManager;
use Sams\Repository\EmployeeRepository;
use Sams\Repository\PermitsRepository;
use Sams\Task\PermitTask;
use Sams\Task\EmployeeTask;


class PermitController extends BaseController {

	 protected $employeeRepository;
	 protected $permitRepository;
	 protected $permitTask;
	 protected $employeeTask;

   public function __construct(EmployeeRepository $employeeRepository, PermitsRepository $permitRepository,
   	 													 PermitTask $permitTask, EmployeeTask $employeeTask)

   {
   	    $this->employeeRepository = $employeeRepository;
   	    $this->permitRepository   = $permitRepository;
   		 $this->permitTask         = $permitTask;
   		 $this->employeeTask       = $employeeTask;
   }

   public function createPermit($id)

   {
   		$employee = $this->employeeRepository->find($id);

   		$this->employeeTask->employeeActiviti($employee);

   		$permit  = $this->permitRepository->getModel();
   		$manager = new PermitsManager($permit, array_add(Input::all(), 'employee_id', $employee->id));
   		$permit  = $manager->validPermit();

   		$this->permitTask->confirmedPermit($permit);
         
   		$manager->save();

   		return Response::json(['status'  => 'success',
   				                     'message' => 'Permiso registrado']);
   }

}