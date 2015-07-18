<?php

use Sams\Manager\InstanceManager;
use Sams\Repository\InstanceRepository;
use Sams\Repository\ElderRepository;
use Sams\Task\InstanceTask;

class InstanceController extends BaseController {

	protected $instanceRepository;
	protected $elderRepository;
	protected $instanceTask;

	public function __construct(InstanceRepository $instanceRepository, ElderRepository $elderRepository,
		                          InstanceTask $instanceTask)

	{

		  $this->instanceRepository = $instanceRepository;
			$this->elderRepository    = $elderRepository;
			$this->instanceTask       = $instanceTask;
	}

	public function addInstance()

	{
		  $data = Input::all();
		  $elderFound = $this->elderRepository->findElderByIdentify(array_only($data, 'identity_card'));
			$instance = $this->instanceRepository->getModel();

			$manager = new InstanceManager($instance, $data);

		  if ($elderFound->count() > 0)

		  {
		  		$elder = $elderFound->first();
		  }

		  else

		  {
		  		$elder = $this->elderRepository->getModel();
		  }

			$manager->createInstance($elder);

			return Response::json(['status'  => 'success',
				                     'message' => 'Notificacion de Ingreso Almacenada']);
	}

	public function confirmedInstance($id)

	{
		  $elder = $this->elderRepository->find($id);
		  $instance = $elder->getInstanceWaiting()->first();
		  
			$this->instanceTask->confirmInstance($instance);

			return Response::json(['status' => 'success',
				                     'message' => 'Notificacion de Entrada Confirmada']);

	}

}




