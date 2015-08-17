<?php

use Sams\Manager\RecordManager;
use Sams\Repository\RecordRepository;
use Sams\Repository\ElderRepository;
use Sams\Task\RecordTask;
use Sams\Task\ElderTask;


class RecordController extends BaseController {

	protected $recordRepository;
	protected $elderRepository;
	protected $recordTask;
	protected $elderTask;

	public function __construct(RecordRepository $recordRepository, ElderRepository $elderRepository, 
		                          RecordTask $recordTask, ElderTask $elderTask)

	{
			$this->recordRepository = $recordRepository;
			$this->elderRepository  = $elderRepository;
			$this->recordTask       = $recordTask;
			$this->elderTask        = $elderTask;
	}

	public function createRecord($id)

	{
		  $elder = $this->elderTask->findElderById($id);
		  
			$this->recordTask->recordCurrentConfirmed($elder->id);
			
			$record  = $this->recordRepository->createRecord();
			$manager = new RecordManager($record, array_add(Input::all(),'elder_id', $elder->id));
			
			$manager->save();

			return Response::json(['status'  => 'success',
				                     'message' => 'Historia Medica Registrada']);
	}
}