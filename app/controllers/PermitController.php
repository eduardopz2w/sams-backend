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

  public function create($employeeId) {
    $employee = $this->employeeRepo->find($employeeId);
    $permit = $this->permitRepo->getModel();
    $data = Input::all();
    $manager = new PermitManager($permit, $data);
    $permit = $manager->saveRelation();
    $permit->employee_id = $employee->id;

    $this->permitTask->confirmedPermit($permit);

    $permit->employee_id = null;

    $employee->permits()->save($permit);
    
    $response = [
      'status' => 'success',
      'message' => 'Permiso registrado'
    ];

    return Response::json($response);
  }

  public function show($employeeId, $permitId) {
    $employee = $this->employeeRepo->find($employeeId);
    $permit = $employee
                ->permits()
                  ->where('id', $permitId)
                  ->first();

    $this->notFound($permit);

    $response = [
      'status' => 'success',
      'data' => $permit
    ];

    return Response::json($response);
  }

  public function permitForEmployee($employeeId) {
    $employee = $this->employeeRepo->find($employeeId);
    $permits = $employee->permits();

    if ($permits->count() == 0) {
      $response = [
        'status' => 'error',
        'message' => 'Empleado no tiene permisos asignados'
      ];
    } else {
      $permits = $permits->get();

      $response = [
        'status' => 'success',
        'data' => $permits
      ];
    }

    return Response::json($response);
  }

     

         

     
   

}