<?php

use Sams\Manager\ImageRecordManager;
use Sams\Manager\ImageEmployeeManager;
use Sams\Repository\RecordRepository;
use Sams\Repository\ElderRepository;
use Sams\Repository\EmployeeRepository;
use Sams\Task\ElderTask;
use Sams\Task\EmployeeTask;
//Empleado task

class ImgController extends BaseController {
	
	 protected $recordRepository;
	 protected $elderRepository;
	 protected $employeeRepository;
	 protected $employeeTask;
	 protected $elderTask;

	 public function __construct(RecordRepository $recordRepository, ElderRepository $elderRepository,
	 	                           ElderTask $elderTask, EmployeeRepository $employeeRepository,
	 	                           EmployeeTask $employeeTask)

	 {
	 			$this->recordRepository   = $recordRepository;
	 			$this->elderRepository    = $elderRepository;		
	 			$this->employeeRepository = $employeeRepository;
	 			$this->elderTask          = $elderTask;
	 			$this->employeeTask       = $employeeTask;
	 }

	 public function addRecordImg($id)

	 {
	 			// $elder = $this->elderRepository->find($id);

	 			// $this->elderTask->elderActiviti($elder);
	 	    $elder = $this->elderTask->findElderById($id);

	 			$record = $this->recordRepository->allRecord($elder->id)->first();

	 			if (Input::hasFile('photo'))

	 			{
	 					$manager = new ImageRecordManager($record, Input::file('photo'));
	 					$manager->upload();
	 			}

	 			else

	 			{
	 					$manager = new ImageRecordManager($record, Input::get('photo'));
	 					$manager->uploadCode();
	 			}

	 			return Response::json(['status'  => 'success',
	 				                     'message' => 'se ha cambiado la imagen']);
	 }

	 public function addEmployeeImg($id)

	 {
	 		// $employee = $this->employeeRepository->find($id);
	 		
	 		// $this->employeeTask->employeeActiviti($employee);

	 	  $employee = $this->employeeTask->findEmployeeById($id);

	 		if (Input::hasFile('photo'))

	 		{
	 				$manager = new ImageEmployeeManager($employee, Input::file('photo'));
	 				$manager->upload();
	 		}

	 		else

	 		{
	 				$manager = new ImageEmployeeManager($employee, Input::get('photo'));
	 				$manager->uploadCode();
	 		}

	 		return Response::json(['status'  => 'success',
	 			                     'message' => 'Se ha registrado nueva imagen del empleado']);
	 }

}