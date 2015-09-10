<?php

use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;
use Sams\Manager\ElderManager;
use Sams\Task\ElderTask;

class ElderController extends BaseController {

  protected $elderRepo;
	protected $recordRepo;
	protected $elderTask;

	public function __construct(ElderRepository $elderRepo, 
		                          RecordRepository $recordRepo,
                              ElderTask $elderTask) {
		$this->elderRepo    = $elderRepo;
    $this->recordRepo   = $recordRepo;
	  $this->elderTask    = $elderTask;
	}
	  
	public function edit($id) {
		$elder   = $this->elderRepo->find($id);
	  $record  = $this->recordRepo->recordCurrent($elder->id);
	  $manager = new ElderManager($elder, Input::except('_method'));

    $manager->save();

    $record = $record->count();

	  $response = [
	  	'status' => 'success',
	    'message' => 'Datos actualizados',
	    'record' => $record
	  ];

	  return Response::json($response);
	}
	
	public function elders($state) {
		$elders = $this->elderTask->getElders($state);

	  return Response::json($elders);
	}
	  
	public function elder($id) {
		$elder = $this->elderRepo->elderWithRecord($id);

	  $this->notFound($elder);

	  $elder = $this->elderTask->format($elder);
	  $response = [
	  	'status' => 'success',
	  	'elder' => $elder,
	  ];

	  return Response::json($response);
	}



}