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
	    'data' => $elder,
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
	  	'data' => $elder,
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

	public function search() {
		$query = Input::get('q');
    $elders = $this->elderRepo->findEldersByName($query);
    
    return Response::json($elders);
	}

	public function confirm($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$activiti = $elder->activiti;

		if ($activiti) {
		  $message = 'Adulto mayor confirmado como no residente';
			$elder->activiti = 0;
		} else {
			$message = 'Adulto mayor confirmado como residente';
			$elder->activiti = 1;
		}

		$elder->save();

		$response = [
			'status' => 'success',
			'message' => $message,
			'data' => $elder
		];

		return Response::json($response);
	}
	  




}