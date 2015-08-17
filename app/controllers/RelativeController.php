<?php

use Sams\Manager\RelativeManager;
use Sams\Repository\RelativeRepository;
use Sams\Task\ElderTask;


class RelativeController extends BaseController {

	protected $elderTask;
	protected $relativeRepo;

	public function __construct(ElderTask $elderTask, RelativeRepository $relativeRepo)

	{
			$this->elderTask    = $elderTask;
			$this->relativeRepo = $relativeRepo;
	}

	public function createRelative()

	{
		  $data     = Input::all();
		  $relative = $this->relativeRepo->getModel();
			$elder    = $this->elderTask->findElderByCredential($data['ident_elder']);
			$manager  = new RelativeManager($relative, array_add($data, 'elder_id', $elder->id));
			$manager->save();

			return Response::json(['status'  => 'success',
				                     'message' => 'Almacenado']);

	}

}
