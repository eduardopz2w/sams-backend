<?php 

use Sams\Manager\ActionManager;
use Sams\Manager\ActionEditManager;
use Sams\Repository\ActionRepository;
use Sams\Task\ActionTask;

class ActionController extends BaseController {

	protected $actionRepo;
	protected $scheduleRepo;
	protected $actionTask;

	public function __construct(ActionTask $actionTask,
	                            ActionRepository $actionRepo) {
		$this->actionRepo   = $actionRepo;
	 	$this->actionTask   = $actionTask;
	}

	public function register() {
	 	$action = $this->actionRepo->getModel();
		$data = Input::all();
	 	$manager = new ActionManager($action, $data);

	 	$manager->save();

	 	$response = [
	 	 	'status' => 'success',
	 	 	'message' => 'Actividad registrada',
	 		'data' => $action
	 	];

	 	return Response::json($response);
	}

	public function actions() {
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
	}


}