<?php

namespace Sams\Manager;

class UserEditManager extends BaseManager {

  public function getRules() {
    $rules = [
      'email' => 'required|email|unique:users,email,'.$this->entity->id
    ];

    return $rules;
  }

}