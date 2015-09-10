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

  public function register() {
    $occasion = $this->occasionRepo->getModel();
    $data = Input::all();
    $manager = new OccasionManager($occasion, $data);

    $manager->isValid();
    $this->occasionTask->confirmOccasion($data);
    $manager->save();

    $response = [
      'status' => 'success',
      'message' => 'Evento Almacenado',
      'data' => $occasion
    ];

    return Response::json($response);

  }

  public function show($id) {
    $occasion = $this->occasionRepo->find($id);

    $this->notFound($occasion);

    $response = [
      'status' => 'success',
      'data' => $occasion
    ];

    return Response::json($response);
  }

  public function edit($id) {
    $occasion = $this->occasionRepo->find($id);
    $data = Input::all();
    $manager = new OccasionManager($occasion, $data);

    $manager->isValid();
    $this->occasionTask->confirmOccasion($data);
    $manager->save();

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

  public function delete($id) {
    $occasion = $this->occasionRepo->find($id);

    $occasion->delete();

    $response = [
      'status' => 'success',
      'message' => 'Evento ha sido eliminado'
    ];

    return Response::json($response);
  }

}