<?php

namespace Sams\Manager;

abstract class BaseManager {

	protected $entity;
	protected $data;
  
  public function __construct($entity, $data)

  {
  		$this->entity = $entity;
  		$this->data   = $data;
  }

  // abstract public function getRules();

  public function getRules()

  {
     return 'test';
  } // Se debe eliminar


  public function isValid()

  {
  	 $rules = $this->getRules();
     $validator = \Validator::make($this->data, $rules);

  	 if ($validator->fails())

  	 {
  	 		throw new ValidationException("Error Processing Request", $validator->messages());
  	 			
  	 }
  }

  public function save()

  {
      // $this->isValid();
      $this->entity->fill($this->prepareData($this->data));
      $this->entity->save();
  }

  public function prepareData($data)

  {
  		return $data;
  }
}