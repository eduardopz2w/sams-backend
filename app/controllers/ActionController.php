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



	/*public function actions() {
		$actions = $this->actionRepo->getActions();
		$message = 'No hay actividades registradas';

		$this->actionTask->countQuantity($actions, $message);

		$response = [
		 	'status' => 'success',
		 	'data' => $actions
		];

		return Response::json($response);
	}

	public function getForDate($date) {
		$response = $this->actionTask->getForDay($date);

		return Response::json($response);
	}

	public function show($id) {
		$action = $this->actionRepo->find($id);

		$this->notFound($action);

		$response = [
			'status' => 'success',
		  'data' => $action
	  ];

		return Response::json($response);
	}

	public function edit($id) {
		$action = $this->actionRepo->find($id);
		$data = Input::all();
		$manager = new ActionEditManager($action, $data);

		$manager->save();

		$response = [
			'status' => 'success',
			'message' => 'Datos actualizados'
		];

		return Response::json($response);
	}

	public function getSchedules($id) {
		$action = $this->actionRepo->find($id);
		$schedules = $action->schedules;
		$message = 'Actividad no posee horarios';

		$this->actionTask->countQuantity($schedules, $message);

		$response = [
			'status' => 'success',
			'data' => $schedules
		];

		return Response::json($response);
	}

	public function state($id) {
		$action = $this->actionRepo->find($id);
		$response = $this->actionTask->changeState($action);

		return Response::json($response);
	}

	public function removeSchedule($id, $scheduleId) {
		$action = $this->actionRepo->find($id);

		$action->schedules()->detach($scheduleId);

		$response = [
			'status' => 'success',
			'message' => 'Horario removido'
		];

		return Response::json($response);
	}

	public function delete($id) {
		$action = $this->actionRepo->find($id);

		$action->delete();

	  $response = [
	  	'status' => 'success',
	  	'message' => 'Activdad eliminada'
	  ];

	  return Response::json($response);
	}*/


}