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

  public function getMessages() {
    $messages = [
      'email.required' => 'Ingrese correo',
      'email.email' => 'Ingrese formato de correo valido',
      'email.unique' => 'Ya existe un usuario registrado con ese correo',
      'password.required' => 'Contraseña es requerida',
      'password.min' => 'Contraseña debe tener al meno 4 caracteres'
    ];

    return $messages;
  }

}