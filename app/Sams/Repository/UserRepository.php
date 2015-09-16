<?php

namespace Sams\Repository;

use Sams\Entity\User;

class UserRepository extends BaseRepository {

  public function getModel() {
    return new User;
  }

  public function getUsers() {
    return User::leftJoin('employees', 'users.employee_id', '=', 'employees.id')
               ->select(
                  'users.email',
                  'users.employee_id',
                  'users.id',
                  'employees.identity_card',
                  'employees.first_name',
                  'employees.last_name'
                );
  }

}