<?php

namespace Sams\Manager;

class EmployeeManager extends BaseManager {

  public function getRules()

  {
    $rules = [
      'identity_card'      => 'required|numeric|unique:employees,identity_card',
      'address'            => 'required',
      'first_name' 		     => 'required|regex:/^[\pL\s]+$/u',
      'last_name'  		     => 'required|regex:/^[\pL\s]+$/u',
      'date_birth' 		     => 'required|date',
      'phone'      		     => 'numeric',
      'gender'             => 'required',
      'degree_instruction' => 'required|in:none,primary,secondary,university',
      'civil_status'       => 'required|in:married,single',
      'office'             => 'required',
    ];
    return $rules;
  }

	public function prepareData($data)

	{
	  $data['activiti'] = 1;
			
		if (!isset($data['break_out']))

		{
		  $data['break_out'] = 0;
		}

		else

		{
		  $data['break_out'] = 1;
		}
    
    array_pull($data, 'photo');
    array_pull($data, 'mime');
    
		return $data;
	}

}