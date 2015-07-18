<?php

namespace Sams\Manager;

class ElderManager extends BaseManager {

  public function prepareData($data)

  {
  	 $this->confirmCheck($data);
  	 return $data;

  }

  public function confirmCheck(&$data)

  {
      $confirmeds = array_only($data, ['retired', 'pensioner']);

      array_walk($confirmeds, function ($item) use (&$data) {
      
       if (!isset($item))
       {
          $data[$item] = 0;
       }
       
     });
  }
}