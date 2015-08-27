<?php

use Sams\Repository\ElderRepository;
use Sams\Repository\InstanceRepository;
use Sams\Repository\CitationRepository;
use Sams\Manager\ElderManager;
use Sams\Task\ElderTask;

class ElderController extends BaseController {

  protected $elderRepo;
	protected $recordRepo;
	protected $instanceRepo;
	protected $citationRepo;
	protected $elderTask;

	public function __construct(ElderRepository $elderRepo, InstanceRepository $instanceRepo,
		                          CitationRepository $citationRepo, ElderTask $elderTask)

	{
	  $this->elderRepo    = $elderRepo;
	  $this->instanceRepo = $instanceRepo;
	  $this->citationRepo = $citationRepo;
	  $this->elderTask    = $elderTask;
	}

	public function updateElder($id)

	{
	  $elder         = $this->elderRepo->find($id);
	  $recordCurrent = $this->recordRepo->getRecordCurrent($elder->id);
	  $manager       = new ElderManager($elder, Input::all());

    $manager->save();

	  return Response::json(['status' => 'success',
				                   'message' => 'Datos actualizados']);
	}

	public function elders($state)

	{
	  $elders = $this->elderTask->getElders($state);

	  return Response::json($elders);
	}

	public function elder($id)

	{
	  $elder = $this->elderRepo->elderWithRecord($id);

	  $this->notFound($elder);

	  $instance = $this->instanceRepo->instanceWaiting($elder->id);
    
	  $citation = $this->citationRepo->citationElder($elder->id);

	  return Response::json(['status' => 'success',
          								 'elder'  => ['identity_card' => $elder->identity_card,
          								              'full_name'     => $elder->full_name,
          								              'address'       => $elder->address,
          								              'gender'        => $elder->gender,
          								              'retired'       => $elder->retired,
          								              'pensioner'     => $elder->pensioner,
          								              'civil_status'  => $elder->civil_status,
          								              'date_birth'    => $elder->date_birth,
          								              'activiti'      => $elder->activiti,
          								              'citation'      => $citation->count(),
          								              'instance'      => $instance->count()]
          							  ]);
	}

}