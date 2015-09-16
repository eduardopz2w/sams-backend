<?php

namespace Sams\Manager;

class UserManager extends BaseManager {

  public function getRules() {
    $rules = [
      'email' => 'required|email|unique:users',
      'password' => 'required|min:4'
    ];

    return $rules;
  }

}