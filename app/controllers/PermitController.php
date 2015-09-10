<?php

use Sams\Manager\PermitManager;
use Sams\Repository\PermitRepository;
use Sams\Repository\EmployeeRepository;
use Sams\Task\PermitTask;


class PermitController extends BaseController {

	protected $permitRepo;
  protected $employeeRepo;
	protected $permitTask;

  public function __construct(PermitRepository $permitRepo, 
                              EmployeeRepository $employeeRepo,
                              PermitTask $permitTask) {
      $this->permitRepo   = $permitRepo;
      $this->employeeRepo = $employeeRepo;
      $this->permitTask   = $permitTask;
   }

   public function createPermit($employeeId) {
      $employee = $this->employeeRepo->find($employeeId);
      $permit = $this->permitRepo->getModel();
      $manager = new PermitManager($permit, array_add(Input::all(), 'employee_id', $employee->id));
      $permit = $manager->validPermit();

      $this->permitTask->confirmedPermit($permit);
      $manager->save();

      return Response::json(['status'  => 'success',
                            'message' => 'Permiso registrado']);
   }

     

         

     
   

}