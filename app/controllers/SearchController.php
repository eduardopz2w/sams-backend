<?php

use Sams\Repository\ElderRepository;

class SearchController extends BaseController {
  protected $elderRepo;

  public function __construct(ElderRepository $elderRepo)

  {
    $this->elderRepo = $elderRepo;
  }

  public function searchElder()

  {
    $query  = Input::get('q');
    $elders = $this->elderRepo->findEldersByName($query);
    return Response::json($elders);
  }
}

