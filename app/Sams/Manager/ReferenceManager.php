<?php

namespace Sams\Manager;

class ReferenceManager extends BaseManager{

	public function getRules()

	{
		 $date = current_date();

			$rules = [
			 'treatment'   => 'required',
			 'expert'      => 'required|regex:/^[\pL\s]+$/u',
			 'description' => 'required',
			 'issued'      => 'required|date|after:'.$date
			];

			return $rules;
	}

}