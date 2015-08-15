<?php

use Sams\Manager\ScheduleManager;
use Sams\Repository\EmployeeRepository;
use Sams\Repository\ScheduleRepository;
use Sams\Repository\ActionRepository;
use Sams\Task\EmployeeTask;
use Sams\Task\ScheduleTask;
use Sams\Task\ActionTask;


class ScheduleController extends BaseController {

	  protected $scheduleRepo;
		protected $employeeRepo;
		protected $actionRepo;
		protected $employeeTask;
		protected $scheduleTask;
		protected $actionTask;

		public function __construct(EmployeeRepository $employeeRepo, ScheduleRepository $scheduleRepo,
			 													EmployeeTask $employeeTask, ScheduleTask $scheduleTask, 
			 													ActionRepository $actionRepo, ActionTask $actionTask)
		
		{
			  $this->scheduleRepo = $scheduleRepo;
				$this->employeeRepo = $employeeRepo;
				$this->actionRepo   = $actionRepo;
				$this->employeeTask = $employeeTask;
				$this->scheduleTask = $scheduleTask;
				$this->actionTask   = $actionTask;
		}

		public function addScheduleEmploye($id)

		{
				$employee = $this->employeeRepo->find($id);
				$this->employeeTask->employeeActiviti($employee);

				$data       = Input::all();
				$isEmployee = true;
				$response   = $this->addSchedule($employee, $data, $isEmployee, $employee->break_out);

				return $response;
		}

		public function addScheduleAction($id)

		{
				$action = $this->actionRepo->find($id);

				$this->actionTask->confirmedAction($action);

				$data       = Input::all();
				$isEmployee = false;
				$timeBreak  = false;
				$response   = $this->addSchedule($action, $data, $isEmployee, $timeBreak);

				return $response;
		}

		public function addSchedule($entity, $data, $isEmployee, $timeBreak)

		{
				$schedule = $this->scheduleRepo->getModel();
				$manager  = new ScheduleManager($schedule, $data);
				
				$manager->validateSchedule($timeBreak);

				$hourIn   = $data['entry_time'];
				$hourOut  = $data['departure_time'];
				$days     = $manager->getDays();
				

				$scheduleConfirmed = $this->scheduleTask->scheduleConfirmed( $hourIn, $hourOut, $days, 
					                                                           $entity, $isEmployee);

				if ($scheduleConfirmed)

				{
						$idSchedule = $manager->save();
						$entity->schedules()->attach($idSchedule);
				}

				return Response::json(['status'  => 'success',
			  	                     'message' => 'Horario asignado']);

		}
}