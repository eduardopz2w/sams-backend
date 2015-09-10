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

  public function prepareData($data) {
    $state = $this->entity->state;

    if ($state != 'A') {
      $data['state'] = 'A';
    }

    return $data;
  }

}