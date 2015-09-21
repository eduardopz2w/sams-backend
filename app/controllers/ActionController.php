<?php 

use Sams\Manager\ActionManager;
use Sams\Manager\ActionEditManager;
use Sams\Repository\ActionRepository;
use Sams\Task\ActionTask;

class ActionController extends BaseController {

	protected $actionRepo;
	protected $actionTask;

	public function __construct(ActionTask $actionTask,
	                            ActionRepository $actionRepo) {
		$this->actionRepo = $actionRepo;
	 	$this->actionTask = $actionTask;
	}

	public function create() {
	 	$action = $this->actionRepo->getModel();
		$data = Input::all();
	 	$manager = new ActionManager($action, $data);

	 	$manager->create();

	 	$response = [
	 	 	'status' => 'success',
	 	 	'message' => 'Actividad registrada',
	 		'data' => $action
	 	];

	 	return Response::json($response);
	}

	public function actions() {
		$actions = $this->actionTask->getActions();
		$response = [
			'status' => 'success',
			'data' => $actions
		];

		return Response::json($response);
	}

	public function actionsToday() {
		$actions = $this->actionTask->getForDay();
		$response = [
			'status' => 'success',
			'data' => $actions
		];

		return Response::json($response);
	}
 
	public function show($actionId) {
		$action = $this->actionRepo->find($actionId);

		$this->notFound($action);

		$response = [
			'status' => 'success',
		  'data' => $action
	  ];

		return Response::json($response);
	}

	public function edit($actionId) {
		$action = $this->actionRepo->find($actionId);
		$data = Input::all();
		$manager = new ActionEditManager($action, $data);

		$manager->edit();

		$response = [
			'status' => 'success',
			'message' => 'Datos actualizados',
			'data' => $action
		];

		return Response::json($response);
	}

	public function state($actionId) {
		$action = $this->actionRepo->find($actionId);
		$response = $this->actionTask->actionState($action);

		return Response::json($response);
	}


	public function delete($actionId) {
		$action = $this->actionRepo->find($actionId);

		$action->delete();

	  $response = [
	  	'status' => 'success',
	  	'message' => 'Actividad eliminada'
	  ];

	  return Response::json($response);
	}

}