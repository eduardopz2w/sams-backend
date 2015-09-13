<?php

namespace Sams\Manager;

class EmployeeManager extends BaseManager {

  public function getRules() {
    $rules = [
      'identity_card' => 'required|numeric|unique:employees,identity_card',
      'address' => 'required',
      'first_name' => 'required|regex:/^[\pL\s]+$/u',
      'last_name'  => 'required|regex:/^[\pL\s]+$/u',
      'date_birth' => 'required|date',
      'phone' => 'numeric',
      'gender' => 'required',
      'degree_instruction' => 'required|in:none,primary,secondary,university',
      'civil_status' => 'required|in:married,single',
      'office' => 'required',
    ];
    
    return $rules;
  }

	public function prepareData($data) {
    if (!isset($data['break_out'])) {
      $data['break_out'] = 0;
    } else {
      $data['break_out'] = 1;
    }
    
    $data['activiti'] = 1;
    $data['image_url'] = 'http://localhost/image/geriatric/default/profile_default_man.png';
    $data['mime'] = 'jpg';

    return $data;
  }

	
			
	
	

}