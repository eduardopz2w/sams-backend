<?php

namespace Sams\Task;

use Sams\Repository\UserRepository;

class UserTask extends BaseTask {

  protected $userRepo;

  public function __construct(UserRepository $userRepo) {
    $this->userRepo = $userRepo;
  }

  public function confirmedUsers() {
    $users = $this->userRepo->getUsers();

    if ($users->count() == 0) {
      $message = 'No hay cuentas de usuario registradas';

      $this->hasException($message);
    }

    $users = $users->get();

    foreach ($users as $user) {
      $user->loadRole();
    }

    return $users;
  }

  public function format($user) {
    $employee = $user->employee;

    if ($employee) {
      $user = [
        'email' => $user->email,
        'role' => $user->role,
        'first_name' => $employee->first_name,
        'last_name' => $employee->last_name
      ];
    }

    return $user;
  }

  public function confirmedUserRol($user) {
    $userAuth = \Auth::user();

    if ($user->hasRole('SuperAdmin') && !$userAuth->hasRole('SuperAdmin')) {
      $message = 'No posee permisos para editar este usuario';

      $this->hasException($message);
    }
  }

}