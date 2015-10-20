<?php

use Sams\Manager\UserManager;
use Sams\Manager\UserEditManager;
use Sams\Repository\EmployeeRepository;
use Sams\Repository\UserRepository;
use Sams\Task\UserTask;


class UserController extends BaseController {

  protected $employeeRepo;
  protected $userRepo;
  protected $userTask;

  public function __construct(EmployeeRepository $employeeRepo,
                              UserRepository $userRepo,
                              UserTask $userTask) {
    $this->employeeRepo = $employeeRepo;
    $this->userRepo = $userRepo;
    $this->userTask = $userTask;
  }

  public function create($employeeId) {
    $employee = $this->employeeRepo->find($employeeId);
    $user = $this->userRepo->getModel();
    $data = Input::except('role');
    $role = Input::get('role');
    $manager = new UserManager($user, $data);
    $user = $manager->saveRelation();

    $employee->user()->save($user);

    if ($role == 1) {
      $user->roles()->attach(1);
      $user->roles()->attach(2);
    } else {
      $user->roles()->attach(2);
    }

    $response = [
      'status' => 'success',
      'message' => 'Cuenta de usuario agregada',
      'data' => $user
    ];

    return Response::json($response);
  }

  public function users() {
    $users = $this->userTask->confirmedUsers();
    $response = [
      'status' => 'success',
      'data' => $users
    ];

    return Response::json($response);
  }

  public function show($employeeId) {
    $employee = $this->employeeRepo->find($employeeId);
    $user = $employee->user;

    $this->notFound($user);
    $user->loadRole();

    $response = [
      'status' => 'success',
      'data' => $user
    ];

    return Response::json($response);
  }

  public function logged() {
    $response = false;
    $user = Auth::user();

    $user->loadRole();

    if (!$user->hasRole('SuperAdmin')) {
      $employee = $user->employee;

      if (!$employee->activiti) {
        $response = [
          'status' => 'error',
          'message' => 'Empleado no activo, no podra ingresar al sistema'
        ];
      }
    }

    if (!$response) {
      $user = $this->userTask->format($user);
      $response = [
       'status' => 'success',
       'data' => $user
      ];
    }

    return Response::json($response);
  }

  public function edit($employeeId, $userId) {
    $user = $this->userRepo->find($userId);
   
    $this->userTask->confirmedUserRol($user);

    $email = Input::only('email');
    $role = Input::get('role');
    $password = Input::get('password');
    $manager = new UserEditManager($user, $email);

    $manager->edit();

    if (strlen($password) >= 4) {
      $user->password = $password;
      $user->save();
    }


    if ($role == 1 && !$user->hasRole('Admin')) {
      $user->roles()->attach(1);
    } elseif ($role == 2) {
      $user->roles()->detach(1);
    }

    $user->loadRole();

    $response = [
      'status' => 'success',
      'message' => 'Cuenta de usuario actualizada',
      'data' => $user
    ];

    return Response::json($response);
  }

  public function delete($employeeId, $userId) {
    $user = $this->userRepo->find($userId);

    $user->delete();

    $response = [
      'status' => 'success',
      'message' => 'Cuenta de usuario eliminada'
    ];

    return Response::json($response);
  }

  public function login() {
    $data = Input::all();
    $credentials = ['email' => $data['email'], 'password' => $data['password']];

    if (Auth::attempt($credentials)) {
      $user = $this->logged();

      return $user;
    } else {
      $response = [
        'status' => 'error',
        'message' => 'Los datos ingresados son incorrectos'
      ];

      return Response::json($response);
    }

  }

  public function logout() {
    Auth::logout();
  }
}