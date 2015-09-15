<?php

use Sams\Manager\ElderManager;
use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;
use Sams\Task\ElderTask;

class ElderController extends BaseController {

  protected $elderRepo;
	protected $recordRepo;
	protected $elderTask;

	public function __construct(ElderRepository $elderRepo, 
		                          RecordRepository $recordRepo,
                              ElderTask $elderTask) {
		$this->elderRepo  = $elderRepo;
    $this->recordRepo = $recordRepo;
	  $this->elderTask  = $elderTask;
	}

	public function edit($id) {
		$elder   = $this->elderRepo->find($id);
	  $record  = $elder
	  						->records()
	  							->where('state', 1)
	  							->count();

	  $manager = new ElderManager($elder, Input::except('_method'));

    $manager->edit();

	  $response = [
	  	'status' => 'success',
	    'message' => 'Datos actualizados',
	    'record' => $record
	  ];

	  return Response::json($response);
	}

	public function show($id) {
		$elder = $this->elderRepo->elderWithRecord($id);

	  $this->notFound($elder);

	  $elder = $this->elderTask->format($elder);
	  $response = [
	  	'status' => 'success',
	  	'elder' => $elder,
	  ];

	  return Response::json($response);
	}

	public function delete($id) {
		$elder = $this->elderRepo->find($id);

		$elder->delete();

		$response = [
			'status' => 'success',
			'message' => 'Adulto mayor eliminado'
		];

		return Response::json($response);
	}
	
	public function elders($state) {
		$elders = $this->elderTask->getElders($state);

		$response = [
			'status' => 'success',
			'data' => $elders
		];

	  return Response::json($response);
	}
	  




}