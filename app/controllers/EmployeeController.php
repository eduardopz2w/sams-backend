<?php

use Sams\Manager\EmployeeManager;
use Sams\Manager\EmployeeEditManager;
use Sams\Repository\EmployeeRepository;
use Sams\Task\EmployeeTask;

class EmployeeController extends BaseController {
   
  protected $employeeRepo;
  protected $employeeTask;

	public function __construct(EmployeeRepository $employeeRepo, EmployeeTask $employeeTask) {
    $this->employeeRepo = $employeeRepo;
    $this->employeeTask = $employeeTask;
  }

  public function employees($state) {
    $employees = $this->employeeTask->getEmployees($state);
    $response = [
      'status' => 'success',
      'data' => $employees
    ];

    return Response::json($response);
  }

  public function create() {
    $employee = $this->employeeRepo->getModel();
    $data = Input::all();
    $manager = new EmployeeManager($employee, $data);
    
    $manager->create();

    if (isset($data['photo'])) {
      $photo = $data['photo'];
      $mime = $data['mime_request'];

      $this->employeeTask->addImg($employee, $photo, $mime); 
    }

    $response = [
      'status' => 'success',
      'message' => 'Empleado registrado',
      'data' => $employee
    ];

    return Response::json($response);
  }

  public function show($id) {
    $employee = $this->employeeRepo->find($id);

    $this->notFound($employee);

    $employee = $this->employeeTask->format($employee);

    return Response::json(['status' => 'success',
                           'employee' => $employee]);
  }

  public function edit($id) {
    $employee = $this->employeeRepo->find($id);
    $data = Input::except('_method');
    $manager = new EmployeeEditManager($employee, $data);

    $manager->edit();

    if (isset($data['photo'])) {
      $photo = $data['photo'];
      $mime = $data['mime_request'];

      $this->employeeTask->addImg($employee, $photo, $mime); 
    }

    $response = [
      'status' => 'success',
      'message' => 'Datos actualizados'
    ];

    return Response::json($response);
  }

  public function delete($employeeId) {
    $employee = $this->employeeRepo->find($employeeId);

    $employee->delete();

    $response = [
      'status' => 'success',
      'message' => 'Empleado eliminado'
    ];

    return Response::json($response);
  }

  // public function getAttendances($id) {
  //   $employee = $this->employeeRepo->find($id);
  //   $attendances = $employee->attendances;

  //   $this->employeeTask->confirmAttendances($attendances);

  //   $response = [
  //     'status' => 'success',
  //     'data' => $attendances
  //   ];

  //   return Response::json($response);
  // }

}