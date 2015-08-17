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
		  $elder    = $this->elderRepo->find($id);
		  $instance = $elder->getInstanceWaiting()->first();
		  
			$this->instanceTask->confirmInstance($instance);

			return Response::json(['status' => 'success',
				                     'message' => 'Notificacion de Entrada Confirmada']);

	}

}




