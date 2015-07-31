<?php

namespace Sams\Manager;

class PermitsManager extends BaseManager {

	 
	public function validPermit()

	{
			$this->isValid();
			$data = $this->data;

			if ($data['type'] == 'extend')

			{
					$this->cheackDate($data['date_star'], $data['date_end']);
					$data = array_only($this->data, ['date_star', 'date_end', 'type', 'reason', 'employee_id']);
			}

			else

			{
					$data = array_only($this->data, ['date_star', 'turn', 'type', 'reason', 'employee_id']);
			}

			$this->entity->fill($this->prepareData($data));
			return $this->entity;
	}

  public function cheackDate($dateStar, $dateEnd)

  {
  		if ($dateStar >= $dateEnd)

  		{
  				throw new ValidationException("Error Processing Request", 'Fecha de inicio debe ser menor a fecha de culminacion');
  		}
  }

  public function save()

  {
  		$this->entity->save();
  }


	 public function getRules()

	 {
	 	   $day = current_date();

	 		 $rules = [
         'reason'    => 'required|regex:/^[\pL\s]+$/u',
         'turn'      => 'required_if:type,normal|in:morning,afternoon,night,complete',
         'type'      => 'required|in:extend,normal',
         'date_star' => 'required|date|after:'.$day,
         'date_end' =>  'required_if:type,extend|date'
	 		 ];
	 		 return $rules;
	 }

	 public function prepareData($data)

	 {
	 			$data['state'] = 1;
	 			return $data;
	 }

}