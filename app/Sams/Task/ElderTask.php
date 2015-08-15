<?php

namespace Sams\Task;

use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;

class ElderTask extends BaseTask {

	protected $elderRepo;
	protected $recordRepo;

	public function __construct(ElderRepository $elderRepo, RecordRepository $recordRepo)

	{
			$this->elderRepo  = $elderRepo;
			$this->recordRepo = $recordRepo;
	}

	public function elderActiviti($id)

	{
		  $elder = $this->elderRepo->find($id);

			if (!$elder->activiti)

			{
				  $message = "Adulto mayor no esta en nomina";
				  $this->hasException($message);
			}

			return $elder;

	}

	public function getElders($state)

	{
			$elders  = $this->elderRepo->getEldersActiviti($state);

			if ($elders->count() > 0)

			{
					$elders = $elders->get();

					$response = ['status' => 'success',
					             'data'   => $elders];
			}

			else

			{
					$response = ['status'  => 'error',
					             'message' => 'No hay registro de adulto mayor'];
			}

			return $response;
	}


}