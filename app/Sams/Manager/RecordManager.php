<?php

namespace Sams\Manager;

class RecordManager extends BaseManager {
	
  public function getRules() {
    $rules = [
      'size_diaper'=> 'in:S,M,L',
      'baston'  => 'in:1 point,3 point, 4 point',
      'index_katz' => 'required',
      'index_lawtonbrody'  => 'required',
      'disability_physical'=> 'required',
      'disability_psychic' => 'required'
    ];

    return $rules;
  }
  
	public function prepareData($data) {
    $data['state'] = 1;
    $data['image_url'] = 'http://localhost/image/geriatric/default/profile_default_man.png';
    $data['mime'] = 'jpg';
    
    return $data;
  }

}