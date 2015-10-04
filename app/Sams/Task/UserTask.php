<?php

namespace Sams\Task;

use Sams\Repository\UserRepository;
use Sams\Repository\CitationRepository;
use Sams\Repository\InstanceRepository;
use Sams\Repository\OutputRepository;

class UserTask extends BaseTask {

  protected $userRepo;

  public function __construct(UserRepository $userRepo,
                              CitationRepository $citationRepo,
                              InstanceRepository $instanceRepo,
                              OutputRepository $outputRepo) {
    $this->userRepo = $userRepo;
    $this->citationRepo = $citationRepo;
    $this->instanceRepo = $instanceRepo;
    $this->outputRepo = $outputRepo;
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
    $date = current_date();
    $employee = $user->employee;
    $instance = $this->instanceRepo
                      ->getInstanceVisited($date)
                       ->count();
    $citation = $this->citationRepo
                       ->getCitationsCurrent($date)
                        ->count();
    $output = $this->outputRepo
                     ->getOutputPernotWaiting($date)
                      ->count();
    if ($employee) {
      $user = [
        'email' => $user->email,
        'role' => $user->role,
        'first_name' => $employee->first_name,
        'last_name' => $employee->last_name,
        'citation' => $citation,
        'output' => $output,
        'instance' => $instance
      ];
    } else {
      $user = [
        'email' => $user->email,
        'role' => $user->role,
        'citation' => $citation,
        'output' => $output,
        'instance' => $instance
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