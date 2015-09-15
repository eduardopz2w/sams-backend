<?php

use Sams\Manager\OccurrenceManager;
use Sams\Manager\OccurrenceEditManager;
use Sams\Repository\ElderRepository;
use Sams\Repository\OccurrenceRepository;
use Sams\Task\OccurrenceTask;

class OccurrenceController extends BaseController {

	protected $elderRepo;
	protected $occurrenceRepo;
	protected $occurrenceTask;

	public function __construct(ElderRepository $elderRepo,
		                          OccurrenceRepository $occurrenceRepo,
		                          OccurrenceTask $occurrenceTask) {
		$this->elderRepo = $elderRepo;
		$this->occurrenceRepo = $occurrenceRepo;
		$this->occurrenceTask = $occurrenceTask;
	}
			
	public function create($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$occurrence = $this->occurrenceRepo->getModel();
		$data = Input::all();
		$manager = new OccurrenceManager($occurrence, $data);
		$occurrence = $manager->saveRelation();

		$elder->occurrences()->save($occurrence);

		if (isset($data['photo'])) {
			$photo = $data['photo'];
			$mime = $data['mime_request'];

      $this->occurrenceTask->addImg($occurrence, $photo, $mime);
    }

    $response = [
    	'status' => 'success',
    	'message' => 'Incidencia guardada'
    ];

    return Response::json($response);
	}

	public function occurrencesForElder($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$occurrences = $this->occurrenceTask->getOccurrences($elder);
		$response = [
			'status' => 'success',
			'data' => $occurrences
		];

		return Response::json($response);
	}

	public function show($elderId, $occurrenceId) {
		$elder = $this->elderRepo->find($elderId);
		$occurrence = $elder
										->occurrences()
											->where('id', $occurrenceId)
											->first();

		$this->notFound($occurrence);

		$response = [
			'status' => 'success',
			'data' => $occurrence
		];

		return Response::json($response);
	}

	public function edit($elderId, $occurrenceId) {
		$occurrence = $this->occurrenceRepo->find($occurrenceId);
		$data = Input::except('_method');
		$manager = new OccurrenceEditManager($occurrence, $data);

		$manager->edit();

		if (isset($data['photo'])) {
			$photo = $data['photo'];
			$mime = $data['mime_request'];

      $this->occurrenceTask->addImg($occurrence, $photo, $mime);
    }

    $response = [
    	'status' => 'success',
    	'message' => 'Incidencia modificada',
    	'data' => $occurrence
    ];

    return Response::json($response);
	}

	public function delete($elderId, $occurrenceId) {
		$occurrence = $this->occurrenceRepo->find($occurrenceId);

		$occurrence->delete();

		$response = [
			'status' => 'success',
			'message' => 'Incidencia eliminada'
		];

		return Response::json($response);
	}


}