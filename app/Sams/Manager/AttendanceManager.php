<?php

namespace Sams\Manager;

class AttendanceManager extends BaseManager {

  public function getRules() {
    $rules = [
      'hour_in' => 'required|date_format:H:i',
      'hour_out' => 'required|date_format:H:i'
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'hour_in.required' => 'Ingrese hora de entrada',
      'hour_in.date_format' => 'Ingrese formato valido para hora de entrada',
      'hour_out.required' => 'Ingrese hora de salida',
      'hour_out.date_format' => 'Ingrese formato valido para hora de salida'
    ];

    return $messages;
  }

  public function prepareData($data) {
    $state = $this->entity->state;

    if ($state != 'A') {
      $data['state'] = 'A';
    }

    return $data;
  }

}