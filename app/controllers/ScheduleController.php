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
	 
	public function addScheduleEmployee($id) {
		$employee = $this->employeeRepo->find($id);
	  $data = Input::all();
	  $isEmployee = true;
		$timeBreak = $employee->break_out;
	  $response = $this->scheduleTask->addSchedule($employee, $data, $isEmployee, $timeBreak);

	  return $response;
  }
	 
	public function addScheduleAction($id) {
		$action = $this->actionRepo->find($id);
	  $data = Input::all();
	  $isEmployee = false;
	  $timeBreak = false;
	  $response = $this->scheduleTask->addSchedule($action, $data, $isEmployee, $timeBreak);

	  return $response;
	}
	  
	public function getScheduleEmp($scheduleId, $employeeId) {
	  $scheduleInEmployee = $this->scheduleRepo->scheduleInEmployee($scheduleId, $employeeId);

    $this->notFoundPivot($scheduleInEmployee);

		$schedule = $this->scheduleRepo->find($scheduleId);
		
		return Response::json(['status' => 'success',
			                     'schedule' => $schedule]);
	}

	public function removeScheduleEmp($scheduleId, $employeeId) {
		$employee = $this->employeeRepo->find($employeeId);
		$data = Input::all();
		$isEmployee = true;
		$timeBreak = $employee->break_out;
		$response = $this->scheduleTask->addSchedule($employee, $data, $isEmployee, $timeBreak);

		$employee->schedules()->detach($scheduleId);

		return $response;
	}

}

