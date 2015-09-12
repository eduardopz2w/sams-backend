<?php

use Sams\Manager\OutputManager;
use Sams\Repository\ElderRepository;
use Sams\Repository\OutputRepository;
use Sams\Task\OutputTask;

class OutputController extends BaseController {

	protected $elderRepo;
	protected $outputRepo;
	protected $outputTask;

	public function __construct(ElderRepository $elderRepo,
		                          OutputRepository $outputRepo, 
		                          OutputTask $outputTask) {
		$this->elderRepo  = $elderRepo;
		$this->outputRepo = $outputRepo;
		$this->outputTask = $outputTask;
	}
		  

	public function create($elderId) {
		$elder = $this->elderRepo->find($elderId);

		$this->outputTask->hasOutput($elder);

		$output = $this->outputRepo->getModel();
		$data = Input::all();
		$manager = new OutputManager($output, $data);

		$manager->isValid();
		$this->outputTask->confirmedDate($data);
		$manager->save();
		$elder->outputs()->save(output);
	}


}