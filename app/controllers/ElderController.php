<?php

use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;
use Sams\Manager\ElderManager;

class ElderController extends BaseController {

	protected $elderRepository;
	protected $recordRepository;

	public function __construct(ElderRepository $elderRepository, RecordRepository $recordRepository)

	{
			$this->elderRepository    = $elderRepository;
			$this->recordRepository   = $recordRepository;
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

			return Response::json(['status' => 'success']);
	}

}