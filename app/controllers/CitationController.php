<?php

use Sams\Manager\CitationManager;
use Sams\Repository\CitationRepository;
use Sams\Repository\ElderRepository;
use Sams\Repository\ReferenceRepository;
use Sams\Task\CitationTask;
use Sams\Task\ElderTask;

class CitationController extends BaseController {

	protected $elderRepo;
	protected $citationRepo;
	protected $referenceRepo;
	protected $citationTask;


	public function __construct(ElderRepository $elderRepo, 
		                          CitationRepository $citationRepo, 
		                          ReferenceRepository $referenceRepo,
		                          CitationTask $citationTask) {
		$this->elderRepo     = $elderRepo;
	 	$this->citationRepo  = $citationRepo;
	 	$this->referenceRepo = $referenceRepo;
		$this->citationTask  = $citationTask;
	}

	public function create($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$citation = $this->citationRepo->getModel();
		$data = Input::all();
		$manager = new CitationManager($citation, $data);

		$manager->isValid();

		$hour = $data['hour'];
		$date = $data['date_day'];

		$this->citationTask->confirmHour($date, $hour);
		$this->citationTask->hourInterval($elder, $hour, $date);
		$manager->save();
		$elder->citations()->save($citation);

		$response = [
			'status' => 'success',
			'message' => 'Cita ha sido guardada'
		];

		return Response::json($response);
	}

	public function citationsForElder($elderId) {
		$elder = $this->elderRepo->find($elderId);
		$citations = $this->citationTask->getElderCitations($elder);
		$response = [
			'status' => 'success',
			'data' => $citations
		];

		return Response::json($citations);
	}

	public function show($elderId, $citationId) {
		$elder = $this->elderRepo->find($elderId);
		$citation = $elder->citations()->where('id', $citationId)->first();

		$this->notFound($citation);

		$response = [
			'status' => 'success',
			'data' => $citation
		];

		return Response::json($response);
	}

	public function edit($elderId, $citationId) {
		$elder = $this->elderRepo->find($elderId);
		$citation = $this->citationRepo->find($citationId);
		$data = Input::except('_method');
		$manager = new CitationManager($citation, $data);

		$manager->isValid();

		$hour = $data['hour'];
		$date = $data['date_day'];

		$this->citationTask->confirmHour($date, $hour);
		$this->citationTask->hourInterval($elder, $hour, $date);
		$manager->save();

		$response = [
			'status' => 'success',
			'message' => 'Cita ha sido modificada'
		];

		return Response::json($response);
	}

	public function delete($elderId , $citationId) {
		$citation = $this->citationRepo->find($citationId);

		$citation->delete();

		$response = [
			'status' => 'success',
			'message' => 'Cita eliminada'
		];

		return Response::json($response);
	}

	public function confirmed($elderId, $citationId) {
		$citation = $this->citationRepo->find($citationId);
		$state = Input::get('state');
    $response = $this->citationTask->confirmedCitation($citation, $state);

    return $response;
	}

	public function citationsCurrent() {
    $citations = $this->citationTask->getCurrentCitations();

    $response = [
    	'status' => 'success',
    	'data' => $citations
    ];

    return Response::json($response);
	}

}