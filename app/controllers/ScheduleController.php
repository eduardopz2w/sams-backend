<?php

use Sams\Manager\ScheduleManager;
use Sams\Repository\EmployeeRepository;
use Sams\Repository\ScheduleRepository;
use Sams\Task\EmployeeTask;
use Sams\Task\ScheduleTask;


class ScheduleController extends BaseController {

	 protected  $scheduleRepository;
		protected $employeeRepository;
		protected $employeeTask;
		protected $scheduleTask;

		public function __construct(EmployeeRepository $employeeRepository, ScheduleRepository $scheduleRepository,
			 													EmployeeTask $employeeTask, ScheduleTask $scheduleTask)
		
		{
			  $this->scheduleRepository = $scheduleRepository;
				$this->employeeRepository = $employeeRepository;
				$this->employeeTask       = $employeeTask;
				$this->scheduleTask       = $scheduleTask;
		}

		public function addSchedule($id)

		{
				$employee = $this->employeeRepository->find($id);
				$this->employeeTask->employeeActiviti($employee);

				$schedule = $this->scheduleRepository->getModel();
				$data     = Input::all();
				$manager  = new ScheduleManager($schedule, $data);
				$manager->validateSchedule($employee->break_out);

				$scheduleConfirmed = $this->scheduleTask->scheduleConfirmed($data['entry_time'], $data['departure_time'],
					                                                          $manager->getDays(), $employee);

				if ($scheduleConfirmed)

				{
						$idSchedule = $manager->save();
						$employee->schedules()->attach($idSchedule);
				}

			  return Response::json(['status'  => 'success',
			  	                     'message' => 'Horario asignado']);
		
		}
}