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

	public function findElderById($id)

	{
			$elder = $this->elderRepo->find($id);
			$this->elderActiviti($elder);

			return $elder;
	}

  public function findElderByCredential($identityCard)

  {
  	  $elder = $this->elderRepo->findElderByIdentify($identityCard);

  		if ($elder->count() == 0)

			{
				  $message = 'Adulto mayor no encontrado';
					$this->hasException($message);
			}
			
			$elder = $elder->first();
			$this->elderActiviti($elder);
			return $elder;
  }

	public function elderActiviti($elder)

	{
			if (!$elder->activiti)

			{
				  $message = "Adulto mayor no residente";
				  $this->hasException($message);
			}

	}

	public function getElders($state)

	{
			$elders  = $this->elderRepo->elders($state);

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