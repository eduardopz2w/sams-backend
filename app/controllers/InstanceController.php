<?php

use Sams\Manager\InstanceManager;
use Sams\Repository\InstanceRepository;
use Sams\Repository\ElderRepository;

class InstanceController extends BaseController {

	protected $instanceRepository;
	protected $elderRepository;

	public function __construct(InstanceRepository $instanceRepository, ElderRepository $elderRepository)

	{

		  $this->instanceRepository = $instanceRepository;
			$this->elderRepository    = $elderRepository;
	}

	public function addInstance()

	{
			$elder = $this->elderRepository->getModel();
			$instance = $this->instanceRepository->getModel();

			$manager = new InstanceManager($instance, Input::all());
			$manager->createInstance($elder);

			return Response::json(['status'  => 'success',
				                     'message' => 'Notificacion de Ingreso Almacenada']);
	}

}