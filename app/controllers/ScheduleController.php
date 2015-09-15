<?php

use Sams\Repository\ScheduleRepository;
use Sams\Repository\EmployeeRepository;
use Sams\Repository\ActionRepository;
use Sams\Task\ScheduleTask;


class ScheduleController extends BaseController {

  protected $scheduleRepo;
	protected $employeeRepo;
	protected $actionRepo;
	protected $scheduleTask;

	public function __construct(ScheduleRepository $scheduleRepo, 
		                          EmployeeRepository $employeeRepo, 
		                          ActionRepository $actionRepo,
			                        ScheduleTask $scheduleTask) {
		$this->scheduleRepo = $scheduleRepo;
	  $this->employeeRepo = $employeeRepo;
	  $this->actionRepo   = $actionRepo;
	  $this->scheduleTask = $scheduleTask;
	}
	 
	public function addScheduleEmployee($employeeId) {
		$employee = $this->employeeRepo->find($employeeId);
	  $data = Input::all();
	  $isEmployee = true;
		$timeBreak = $employee->break_out;
	  $response = $this->scheduleTask->addSchedule($employee, $data, $isEmployee, $timeBreak);

	  return $response;
  }

  public function schedulesEmployee($employeeId) {
  	$employee = $this->employeeRepo->find($employeeId);
  	$schedules = $employee->schedules();

  	if ($schedules->count() == 0) {
  		$response = [
  			'status' => 'error',
  			'message' => 'Empleado no tiene horarios asignados'
  		];
  	} else {
  		$schedules = $schedules->get();

  		$response = [
  			'status' => 'success',
  			'data' => $schedules
  		];
  	}

  	return Response::json($response);

  }

  public function showScheduleEmployee($employeeId, $scheduleId) {
	  $scheduleInEmployee = $this->scheduleRepo->scheduleInEmployee($scheduleId, $employeeId);

    $this->notFoundPivot($scheduleInEmployee);

		$schedule = $this->scheduleRepo->find($scheduleId);

		$response = [
			'status' => 'success',
			'data' => $schedule
		];
		
		return Response::json($response);
	}

  public function removeScheduleEmployee($employeeId, $scheduleId) {
		$employee = $this->employeeRepo->find($employeeId);

		$employee->schedules()->detach($scheduleId);

		$response = [
			'status' => 'success',
			'message' => 'Horario ha sido eliminado de empleado'
		];

		return Response::json($response);
	}
	 
	public function addScheduleAction($actionId) {
		$action = $this->actionRepo->find($actionId);
	  $data = Input::all();
	  $isEmployee = false;
	  $timeBreak = false;
	  $response = $this->scheduleTask->addSchedule($action, $data, $isEmployee, $timeBreak);

	  return $response;
	}

  public function schedulesAction($actionId) {
    $action = $this->actionRepo->find($actionId);
    $schedules = $action->schedules();

    if ($schedules->count() == 0) {
      $response = [
        'status' => 'error',
        'message' => 'Actividad no tiene horarios asignados'
      ];
    } else {
      $schedules = $schedules->get();
      $response = [
        'status' => 'success',
        'data' => $schedules
      ];
    }

    return Response::json($response);
  }

  public function removeScheduleAction($actionId, $scheduleId) {
    $action = $this->actionRepo->find($actionId);
    
    $action->schedules()->detach($scheduleId);

    $response = [
      'status' => 'success',
      'message' => 'Horario ha sido eliminado de actividad'
    ];

    return Response::json($response);
  }
	  
	

	

}

