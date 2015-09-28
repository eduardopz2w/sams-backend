<?php

use Sams\Manager\OutputManager;
use Sams\Manager\OutputEditManager;
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
		$type = Input::get('type');

		if ($type == 'pernot') {
			$data = Input::all();
		} else {
			$data = Input::only('info', 'type');
		}

		$manager = new OutputManager($output, $data);

		$manager->isValid();
		$this->outputTask->confirmedDate($data);
		
		$output = $manager->saveRelation();

		$elder->outputs()->save($output);

		$response = [
		 'status' => 'success',
		 'message' => 'Salida guardada'
		];

		return Response::json($response);
	}

	public function show($elderId, $outputId) {
		$elder = $this->elderRepo->find($elderId);
		$output = $elder->outputs()->where('id', $outputId)->first();

		$this->notFound($output);

		$response = [
			'status' => 'success',
			'data' => $output
		];

		return Response::json($response);
	}

	public function edit($elderId, $outputId) {
		$output = $this->outputRepo->find($outputId);

		$state = $output->state;
		$type = $output->type;

		if ($state || $type == 'normal') {
			$data = Input::only('info', 'type');
		} else {
			$data = Input::all();
		}

		$manager = new OutputEditManager($output, $data);

		$manager->edit();

		$response = [
			'status' => 'success',
			'data' => $output,
			'message' => 'Salida ha sido actualizada'
		];

		return Response::json($response);
	}

	public function confirmed($elderId, $outputId) {
		$output = $this->outputRepo->find($outputId);

		$this->outputTask->confirmed($output);

		$response = [
			'status' => 'success',
			'message' => 'Salida confirmada'
		];

		return Response::json($response);
	}

	public function delete($elderId, $outputId) {
		$output = $this->outputRepo->find($outputId);

		$output->delete();

		$response = [
			'status' => 'success',
			'message' => 'Salida eliminada'
		];

		return Response::json($response);
	}

	public function outputsForElder($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$outputs = $this->outputTask->getOutputElder($elder);
		$response = [
			'status' => 'success',
			'data' => $outputs
		];

		return Response::json($response);
	}

	public function getOutputType($type) {
		$outputs = $this->outputTask->getOutputType($type);
		$response = [
			'status' => 'success',
			'data' => $outputs
		];

		return Response::json($response);
	}

	public function getOutputWaiting() {
		$outputs = $this->outputTask->getOutputWaiting();
		$response = [
			'status' => 'success',
			'data' => $outputs
		];

		return Response::json($response);
	}



}