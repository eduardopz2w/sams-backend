<?php 

use Sams\Manager\ActionManager;
use Sams\Repository\ActionRepository;
use Sams\Task\ActionTask;

class ActionController extends BaseController {

	 protected $actionRepo;
	 protected $actionTask;

	 public function __construct(ActionTask $actionTask, ActionRepository $actionRepo)

	 {
	 	   $this->actionRepo = $actionRepo;
	 		 $this->actionTask = $actionTask;
	 }

	 public function registerAction()

	 {
	 		 $data = Input::all();
	 		 $this->actionTask->confirmedEmployee($data);

	 		 $action  = $this->actionRepo->getModel();
	 		 $manager = new ActionManager($action, $data);

	 		 $manager->isValid();

	 		 $this->actionTask->confirmData($data);

	 		 $idActIon = $manager->save();

	 		 return Response::json(['status'  => 'success',
	 		 	                      'message' => 'Actividad registrada',
	 		 	                      'id'      => $idActIon]);
	 }


	 public function getActions($date)

	 {
	 		 $actions = $this->actionTask->getActionNormal($date);		 
	 		 return Response::json($actions);
	 }

	 public function getEvents($date)

	 {
	 		 $actions = $this->actionTask->getActionSpecial($date);
	 		 return Response::json($actions);
	 }

}