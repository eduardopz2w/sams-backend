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
	 		 $data   = Input::all();
	 		 $action = $this->actionRepo->getModel();
       
	 		 $this->actionTask->confirmedEmployee($data['employee_id']);

	 		 $manager = new ActionManager($action, $data);
	 		 $action  = $manager->validateAction();

	 		 $this->actionTask->confirmedType($action);

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