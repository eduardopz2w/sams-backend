<?php

namespace Sams\Manager;

class OutputEditManager extends BaseManager {

  public function getRules() {
    $state = $this->entity->state;

    if (!$state) {
      $rules = [
        'type' => 'required|in:normal,pernot',
        'date_start' => 'required_if:type,pernot|date',
        'date_end' => 'required_if:type,pernot|date',
        'info' => 'required'
      ];
    } else {
      $rules = [
        'info' => 'required'
      ];
    }

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'type.required' => 'Ingrese tipo de salida',
      'type.in' => 'Tipo de salida ingresada es inválido',
      'date_start.required_if' => 'Ingrese fecha de salida',
      'date_end.required_if' => 'Ingrese fecha de retorno',
      'info.required' => 'Informacion es requerida'
    ];

    return $messages;
  }

}