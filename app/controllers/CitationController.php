<?php

use Sams\Manager\CitationManager;
use Sams\Manager\ReferenceManager;
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
	protected $elderTask;

	public function __construct(CitationTask $citationTask, ElderRepository $elderRepo, ElderTask $elderTask, 
		                          CitationRepository $citationRepo, ReferenceRepository $referenceRepo)

	{
		$this->elderRepo     = $elderRepo;
	 	$this->citationRepo  = $citationRepo;
	 	$this->referenceRepo = $referenceRepo;
	 	$this->elderTask     = $elderTask;
		$this->citationTask  = $citationTask;
	}

	public function createCitation($id)

	{
		$elder    = $this->elderTask->findElderById($id);
		$data     = Input::all();
		$citation = $this->citationRepo->getModel();
		$manager  = new CitationManager($citation, array_add($data,'elder_id', $id));
		$hour     = $data['hour'];
		$dateDay  = $data['date_day'];

		$manager->isValid();

		$this->citationTask->hourInterval($elder->id, $hour, $dateDay);
	 			
		$manager->save();

		return Response::json(['status'  => 'success',
	 				                     'message' => 'cita guardada']);
	}

	 // public function confirmedCitation($id, $confirmed = null, $notification = null)

	 // {
	 // 	    // arreglar
	 // 	    $citation = $this->citationRepo->find($id);
	 // 	    $this->citationTask->citationConfirmed($citation);

	 // 	    $elder = $citation->elder;
        
	 // 			if ($notification)

	 // 			{  
	 // 				  // manager citation
	 // 				  $data       = Input::all();
	 // 				  $relation   = ['elder_id' => $elder->id, 'citation_id' => $citation->id];
	 // 				  $data       = array_merge($data, $relation);
	 // 				  $references = $this->referenceRepo->getModel();
	 // 					$manager    = new ReferenceManager($references, $data);		

	 // 					$manager->save();

	 // 			}

	 // 			$message = $this->citationTask->stateCitation($citation, $confirmed, $notification);

	 // 			return Response::json(['status'  => 'success',
	 // 				                     'message' => $message]);
	 // }

	public function citationDate($date)

	{
	  $citations = $this->citationRepo->getCitationsDate($date);
		$citations = $this->citationTask->citationConfirmedDate($citations);

		return Response::json(['status' => 'success',
	 		 	                    'data'   => $citations]);
	}

	public function citationHour()

	{	
	  $citations = $this->citationTask->citationConfirmHour();
	 		
	 	return Response::json(['status' => 'success',
	 			                   'data'  => $citations]);
	}

}