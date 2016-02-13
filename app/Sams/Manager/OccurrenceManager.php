<?php

namespace Sams\Manager;

class OccurrenceManager extends BaseManager {

  public function getRules() {
    $date = current_date();
    $day = 1;
    $date =  add_date($day, $date);
    $rules = [
      'case_situation' => 'required',
      'date' => 'required|date|before:'.$date
    ];

    return $rules;
  }

   public function getMessages() {
    $messages = [
      'case_situation.required' => 'Ingrese situacion del caso',
      'date.required'  => 'Ingrese fecha',
      'date.date' => 'Ingrese formato valido para fecha',
      'date.before' => 'Fecha no ha pasado'
    ];

    return $messages;
  }

  public function prepareData($data) {
    $data['image_url'] = 'http://localhost/image/geriatric/default/profile_default_man.png';
    $data['mime'] = 'jpg';

    return $data;
  }
}