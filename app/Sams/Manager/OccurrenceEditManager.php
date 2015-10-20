<?php

namespace Sams\Manager;

class OccurrenceEditManager extends BaseManager {
  public function getRules() {
    $rules = [
      'case_situation' => 'required',
      'date' => 'required|date'
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'case_situation.required' => 'Ingrese situacion del caso',
      'date.required'  => 'Ingrese fecha',
      'date.date' => 'Ingrese formato valido para fecha'
    ];

    return $messages;
  }

}