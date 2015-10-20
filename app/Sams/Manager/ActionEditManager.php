<?php

namespace Sams\Manager;

class ActionEditManager extends BaseManager {

  public function getRules() {
    $rules = [
      'name' => 'required|regex:/^[\pL\s]+$/u|unique:actions,name,'.$this->entity->id,
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'name.required' => 'Nombre de actividad es requerido',
      'name.regex' => 'Ingrese formato de nombre valido',
      'name.unique' => 'Ya existe actividad registrada con ese nombre'
    ];

    return $messages;
  }

}