<?php

namespace Sams\Manager;

class OccurrenceManager extends BaseManager {

  public function getRules() {
    $rules = [
      'case_situation' => 'required',
      'date' => 'required|date'
    ];

    return $rules;
  }

  public function prepareData($data) {
    $data['image_url'] = 'http://localhost/image/geriatric/default/profile_default_man.png';
    $data['mime'] = 'jpg';

    return $data;
  }
}