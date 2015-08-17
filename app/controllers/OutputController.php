<?php

use Sams\Manager\OutputManager;
use Sams\Repository\OutputRepository;
use Sams\Task\OutputTask;

class OutputController extends BaseController {

	protected $outputRepo;
	protected $outputTask;

	public function __construct(OutputRepository $outputRepo, OutputTask $outputTask)

	{
		  $this->outputRepo = $outputRepo;
			$this->outputTask = $outputTask;
	}

	public function createOutput()

	{
			$data   = Input::all();
		  $elder  = $this->outputTask->elderConfimed($data);
			$output = $this->outputRepo->getModel();

			$manager = new OutputManager($output, $data);
			$manager->isValid();
      
			$this->outputTask->confirmedDate($data);
			$acompanist = $this->outputTask->accompanistConfirm($data);
			$output = $manager->save();
      
      $this->outputTask->addAcompanit($output, $acompanist);

      return Response::json(['status'  => 'success',
      	                     'message' =>  'Permiso almacenado']);

	}

}