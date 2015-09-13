<?php

use Sams\Manager\InstanceManager;
use Sams\Manager\InstanceEditManager;
use Sams\Repository\InstanceRepository;
use Sams\Repository\ElderRepository;
use Sams\Task\ElderTask;
use Sams\Task\InstanceTask;

class InstanceController extends BaseController {

	protected $instanceRepo;
	protected $elderRepo;
	protected $instanceTask;

  public function __construct(InstanceRepository $instanceRepo, 
  	                          ElderRepository $elderRepo,
	                            InstanceTask $instanceTask, 
	                            ElderTask $elderTask) {
  	$this->elderRepo    = $elderRepo;
		$this->instanceRepo = $instanceRepo;
	  $this->instanceTask = $instanceTask;
  }

	public function create() {
	  $this->instanceTask->maxElders();

	  $instance = $this->instanceRepo->getModel();
	  $data = Input::all();
	  $manager = new InstanceManager($instance, $data);

	  $instance = $manager->saveRelation();
		$elder = $this->instanceTask->elderFound($data['identity_card']);

	  $elder->instances()->save($instance);

	  $response = [
	  	'status' => 'success',
	  	'message' => 'Notificacion de entrada almacenada',
	  	'data' => $elder
	  ];
	 
	  return Response::json($response);
	}

	public function edit($elderId, $instanceId) {
		$instance = $this->instanceRepo->find($instanceId);
		$elder = $instance->elder;
		$data = Input::except('_method');
		$manager = new InstanceEditManager($instance, $data);

		$manager->edit();

		$elder->identity_card = $data['identity_card'];

		$elder->save();

		$response = [
			'status' => 'success',
			'message' => 'Notificacion de entrada confirmada',
			'data' => $elder
		];

		return Response::json($response);
	}

	public function instanceWaiting($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$instance = $elder
									->instances()
										->where('state', 'waiting')
										->first();

		$this->notFound($instance);

		$instance = $this->instanceTask->format($elder, $instance);
		$response = [
			'status' => 'success',
			'data' => $instance
		];

		return $response;
	}

	public function confirmed($elderId, $instanceId) {
		$instance = $this->instanceRepo->find($instanceId);
	  $state = Input::get('state');
		$response = $this->instanceTask->confirmInstance($instance, $state);

		return Response::json($response);
	}

	public function instancesWaiting() {
		$instances = $this->instanceTask->getInstancesWaiting();
		$response = [
			'status' => 'success',
			'data' => $instances
		];

		return Response::json($response);
	}

	public function instancesElder($elderId) {
		$elder = $this->elderRepo->find($elderId);
    $instances = $this->instanceTask->getInstancesElder($elder);
    $response = [
    	'status' => 'success',
    	'data' => $instances
    ];

    return Response::json($response);
	}

}




