<?php

use Sams\Manager\PermitsManager;
use Sams\Repository\PermitsRepository;
use Sams\Task\PermitTask;
use Sams\Task\EmployeeTask;


class PermitController extends BaseController {

	 protected $permitRepository;
	 protected $permitTask;
	 protected $employeeTask;

   public function __construct(PermitsRepository $permitRepository, PermitTask $permitTask, 
                               EmployeeTask $employeeTask)

   {
   	  $this->permitRepository = $permitRepository;
   	  $this->permitTask       = $permitTask;
   	  $this->employeeTask     = $employeeTask;
   }

   public function createPermit($id)

   {
         $employee = $this->employeeTask->findEmployeeById($id);
   		$permit   = $this->permitRepository->getModel();
   		$manager  = new PermitsManager($permit, array_add(Input::all(), 'employee_id', $employee->id));
   		$permit   = $manager->validPermit();

   		$this->permitTask->confirmedPermit($permit);
         
   		$manager->save();

   		return Response::json(['status'  => 'success',
   				                 'message' => 'Permiso registrado']);
   }

}