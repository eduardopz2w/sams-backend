<?php

namespace Sams\Manager;

class PermitManager extends BaseManager {
  public function getRules() {
    $day = current_date();
    $rules = [
      'reason' => 'required|regex:/^[\pL\s]+$/u',
      'turn' => 'required_if:type,normal|in:morning,afternoon,night,complete',
      'type' => 'required|in:extend,normal',
      'date_start' => 'required|date|after:'.$day,
      'date_end' => 'required_if:type,extend|date'
    ];

    return $rules;
  }

  public function prepareData($data) {
    $data['state'] = 'espera';

    return $data;
  }

}

 