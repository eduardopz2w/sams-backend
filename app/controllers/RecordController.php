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
		  $elder = $this->elderRepository->find($id);
		  $this->elderTask->elderActiviti($elder);
			$recordCurrent = $this->recordRepository->getRecordCurrent($elder->id);
			$this->recordTask->recordCurrentConfirmed($recordCurrent);
			
			$data    = Input::all();
			$record  = $this->recordRepository->createRecord($elder->gender);
			$manager = new RecordManager($record, array_add($data,'elder_id', $elder->id));
			$manager->save();

			return Response::json(['status'  => 'success',
				                     'message' => 'Historia Medica Registrada']);
	}
}