<?php

use Sams\Repository\ScheduleRepository;
use Sams\Task\EmployeeTask;
use Sams\Task\ScheduleTask;
use Sams\Task\ActionTask;


class ScheduleController extends BaseController {

	  protected $scheduleRepo;
		protected $employeeTask;
		protected $scheduleTask;
		protected $actionTask;

		public function __construct(ScheduleRepository $scheduleRepo, EmployeeTask $employeeTask, 
			                          ScheduleTask $scheduleTask, ActionTask $actionTask)
		
		{
			  $this->scheduleRepo = $scheduleRepo;
				$this->employeeTask = $employeeTask;
				$this->scheduleTask = $scheduleTask;
				$this->actionTask   = $actionTask;
		}

		public function addScheduleEmploye($id)

		{
	 	    $employee = $this->employeeTask->findEmployeeById($id);

				$data       = Input::all();
				$isEmployee = true;
				$timeBreak  = $employee->break_out;
				$response   = $this->scheduleTask->addSchedule($employee, $data, $isEmployee, 
					                                             $timeBreak);

				return $response;
		}

		public function addScheduleAction($id)

		{
				$action     = $this->actionTask->confirmedAction($id);
				$data       = Input::all();
				$isEmployee = false;
				$timeBreak  = false;
				$response   = $this->scheduleTask->addSchedule($action, $data, $isEmployee, 
					                                             $timeBreak);

				return $response;
		}

}

