<?php

use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;
use Sams\Manager\ElderManager;
use Sams\Task\ElderTask;

class ElderController extends BaseController {

	protected $elderRepository;
	protected $recordRepository;
	protected $elderTask;

	public function __construct(ElderRepository $elderRepository, RecordRepository $recordRepository,
		                          ElderTask $elderTask)

	{
			$this->elderRepository  = $elderRepository;
			$this->recordRepository = $recordRepository;
			$this->elderTask        = $elderTask;
	}

	public function updateElder($id)

	{
			$elder = $this->elderRepository->find($id);

			$recordCurrent = $this->recordRepository->getRecordCurrent($elder->id);
			$manager = new ElderManager($elder, Input::all());
			
			$manager->save();

			if ($elder->activiti && $recordCurrent->count() == 0)

			{
					return Response::json(['status'  => 'info',
						                     'message' => 'Recuerda registrar historia clinica']);
			}

			return Response::json(['status' => 'success',
				                     'message' => 'Datos actualizados']);
	}

	public function elders($state)

	{
			$elders = $this->elderTask->getElders($state);

			return Response::json($elders);
	}

}