<?php

//404
use Sams\Manager\OccurrenceManager;
use Sams\Manager\ImageOccurrenceManager;
use Sams\Repository\ElderRepository;
use Sams\Repository\OccurrenceRepository;
use Sams\Task\ElderTask;

class OccurrenceController extends BaseController {

	protected $elderRepository;
	protected $occurrenceRepository;
	protected $elderTask;

	public function __construct(ElderRepository $elderRepository, ElderTask $elderTask,
		                          OccurrenceRepository $occurrenceRepository)

	{
			$this->elderRepository      = $elderRepository;
			$this->elderTask            = $elderTask;
			$this->occurrenceRepository = $occurrenceRepository;
	}

	public function createOccurrence($id)

	{
			$elder = $this->elderRepository->find($id);

			$this->elderTask->elderActiviti($elder);

			$occurrence = $this->occurrenceRepository->getModel();
			$data       = Input::except('photo');
			$photo      = Input::get('location');
			$manager    = new OccurrenceManager($occurrence, array_add($data, 'elder_id', $elder->id));

			$manager->save();

			if (!empty($photo))

			{
					$entity  = $manager->getOccurrence();
					$manager = new ImageOccurrenceManager($entity, $photo);

					$manager->uploadCode();

			}

			return Response::json(['status'  => 'success',
				                     'message' => 'Incidencia guardada']);

	}

}