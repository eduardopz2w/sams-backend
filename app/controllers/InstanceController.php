<?php

use Sams\Manager\InstanceManager;
use Sams\Repository\InstanceRepository;
use Sams\Repository\ElderRepository;
use Sams\Task\ElderTask;
use Sams\Task\InstanceTask;

class InstanceController extends BaseController {

	protected $instanceRepo;
	protected $elderRepo;
	protected $instanceTask;

  public function __construct(InstanceRepository $instanceRepo, ElderRepository $elderRepo,
	                            InstanceTask $instanceTask, ElderTask $elderTask)
	{
	  $this->elderRepo    = $elderRepo;
		$this->instanceRepo = $instanceRepo;
	  $this->instanceTask = $instanceTask;
	}

	public function addInstance()

	{
	  $this->instanceTask->maxElders();

		$data     = Input::all();
		$elder    = $this->instanceTask->elderFound($data['identity_card']);
	  $instance = $this->instanceRepo->getModel();
	  $manager  = new InstanceManager($instance, $data);

		$this->instanceTask->confirmElder($elder);  
	  $manager->createInstance($elder);

	  return Response::json(['status'  => 'success',
				                   'message' => 'Notificacion de Ingreso Almacenada']);
	}

	public function confirmedInstance($id)

	{
	  $instance = $this->instanceRepo->instanceWaiting($id)->first();
	  $state    = Input::get('state');
		$response = $this->instanceTask->confirmInstance($instance, $state);

		return Response::json($response);
	}

	public function instanceWaitingElder($id)

	{
	  $instance = $this->instanceTask->getInstaceWaiting($id);

	  return Response::json(['status'   => 'success',
	  	                     'instance' => ['referred'    => \Lang::get('utils.referred_instance.'.$instance->referred),
	  	                                    'address'     => $instance->address,
	  	                                    'visit_date'  => $instance->visit_date,
	  	                                    'description' => $instance->description]
	  	                    ]);
	}

}




