<?php

use Sams\Manager\OccasionManager;
use Sams\Repository\OccasionRepository;
use Sams\Task\OccasionTask;

class OccasionController extends BaseController {

  protected $occasionRepo;
  protected $occasionTask;

  public function __construct(OccasionRepository $occasionRepo,
                              OccasionTask $occasionTask) {
    $this->occasionRepo = $occasionRepo;
    $this->occasionTask = $occasionTask;
  }

  public function create() {
    $occasion = $this->occasionRepo->getModel();
    $data = Input::all();
    $manager = new OccasionManager($occasion, $data);

    $manager->isValid();
    $this->occasionTask->confirmOccasion($data);
    $manager->create();

    $response = [
      'status' => 'success',
      'message' => 'Evento Almacenado',
      'data' => $occasion
    ];

    return Response::json($response);

  }

  public function show($occasionId) {
    $occasion = $this->occasionRepo->find($occasionId);

    $this->notFound($occasion);

    $response = [
      'status' => 'success',
      'data' => $occasion
    ];

    return Response::json($response);
  }

  public function edit($occasionId) {
    $occasion = $this->occasionRepo->find($occasionId);
    $data = Input::all();
    $manager = new OccasionManager($occasion, $data);

    $manager->isValid();
    $this->occasionTask->confirmOccasion($data);
    $manager->edit();

    $response = [
      'status' => 'success',
      'message' => 'Evento Actualizado',
      'data' => $occasion
    ];

    return Response::json($response);
  }

  public function getForDate() {
    $date = Input::get('date');
    
    $this->occasionTask->validateDate($date);

    $occasions = $this->occasionRepo->getForDate($date);
    $occasions = $this->occasionTask->confirmOccasionForDate($occasions);
    $response = [
      'status' => 'success',
      'data' => $occasions
    ];

    return Response::json($response);
  }

  public function delete($occasionId) {
    $occasion = $this->occasionRepo->find($occasionId);

    $occasion->delete();

    $response = [
      'status' => 'success',
      'message' => 'Evento ha sido eliminado'
    ];

    return Response::json($response);
  }

}