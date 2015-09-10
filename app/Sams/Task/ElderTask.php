<?php

namespace Sams\Task;

use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;
use Sams\Repository\CitationRepository;
use Sams\Repository\InstanceRepository;

class ElderTask extends BaseTask {

	protected $elderRepo;
	protected $recordRepo;
	protected $citationRepo;
	protected $instanceRepo;

	public function __construct(ElderRepository $elderRepo, RecordRepository $recordRepo,
		                          CitationRepository $citationRepo, InstanceRepository $instanceRepo)

	{
	  $this->elderRepo    = $elderRepo;
		$this->recordRepo   = $recordRepo;
		$this->citationRepo = $citationRepo;
		$this->instanceRepo = $instanceRepo;

	}

	// public function findElderById($id)

	// {
	// 	   $elder = $this->elderRepo->find($id);
	// 	   $this->elderActiviti($elder);

	// 		return $elder;
	// }

  // public function findElderByCredential($identityCard)

  // {
  // 	  $elder = $this->elderRepo->findElderByIdentify($identityCard);

  // 		if ($elder->count() == 0)

		// 	{
		// 		  $message = 'Adulto mayor no encontrado';
		// 			$this->hasException($message);
		// 	}
			
		// 	$elder = $elder->first();
		// 	$this->elderActiviti($elder);
		// 	return $elder;
  // }

	// public function elderActiviti($elder)

	// {
	// 		if (!$elder->activiti)

	// 		{
	// 			  $message = "Adulto mayor no residente";
	// 			  $this->hasException($message);
	// 		}

	// }

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

	public function format($elder)

	{
	  $instance = $this->instanceRepo->instanceWaiting($elder->id);   
	  $citation = $this->citationRepo->citationElder($elder->id);

	  $elder = ['identity_card' => $elder->identity_card,
              'full_name'     => $elder->full_name,
              'address'       => $elder->address,
              'gender'        => $elder->gender,
              'retired'       => $elder->retired,
              'pensioner'     => $elder->pensioner,
              'civil_status'  => \Lang::get('utils.civil_status.'. $elder->civil_status),
              'date_birth'    => $elder->date_birth,
              'activiti'      => $elder->activiti,
              'image_url'     => $elder->image_url,
              'citation'      => $citation->count(),
              'instance'      => $instance->count()];
              
    return $elder;
	}


}