<?php

namespace Sams\Manager;

class RecordManager extends BaseManager {
	
	public function prepareData($data)

	{
		 $data['state'] = 1;
     $this->confirmCheck($data);
		 return $data;
	}

	public function confirmCheck(&$data)

	{
		 $confirmeds = array_only($data, ['feeding_assisted', 'wheelchair', 'walker', 'self_validating']);

     array_walk($confirmeds, function ($item) use (&$data) {
     	
     	 if (!isset($item))
     	 {
     			$data[$item] = 0;
     	 }
     	 
     });
	}

}