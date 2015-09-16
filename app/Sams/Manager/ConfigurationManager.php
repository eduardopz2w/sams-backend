<?php

namespace Sams\Manager;

class ConfigurationManager extends BaseManager {

  public function getRules() {
    $rules = [
      'name_institution' => 'required',
      'max_hours' => 'required|date_format:H:i',
      'max_permits' => 'required|numeric',
      'max_impeachment' => 'required|numeric'
    ];

    return $rules;
  }

}