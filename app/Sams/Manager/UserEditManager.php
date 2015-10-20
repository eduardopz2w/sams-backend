<?php

namespace Sams\Manager;

class UserEditManager extends BaseManager {

  public function getRules() {
    $rules = [
      'email' => 'required|email|unique:users,email,'.$this->entity->id
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'email.required' => 'Ingrese correo',
      'email.email' => 'Ingrese formato de correo valido',
      'email.unique' => 'Ya existe un usuario registrado con ese correo',
    ];

    return $messages;
  }

}