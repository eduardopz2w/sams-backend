<?php

namespace Sams\Manager;

class PermitsManager extends BaseManager {

	 
	public function validPermit()

	{
			$this->isValid();

			$data    = $this->data;
			$type    = $data['type'];
			$dateIn  = $data['date_star'];
			$dateEnd = $data['date_end'];

			if ($type == 'extend')

			{
					$this->cheackDate($dateIn, $dateEnd);
			}

			$this->entity->fill($this->prepareData($this->data));
			return $this->entity;
	}

  public function cheackDate($dateStar, $dateEnd)

  {
  		if ($dateStar >= $dateEnd)

  		{
  			  $message = 'Fecha en que termina el permiso debe ser menor a su inicio';
  				throw new ValidationException("Error Processing Request", $message);
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
	 	    if (!$data['date_end'])

	 	    {
	 	    		array_pull($data, 'date_end');
	 	    }

	 	    else

	 	    {
	 	    		array_pull($data, 'turn');
	 	    }

	 			$data['state'] = 1;
	 			return $data;
	 }

}