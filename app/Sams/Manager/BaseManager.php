<?php

namespace Sams\Manager;

abstract class BaseManager {

	public $entity;
	protected $data;
  
  public function __construct($entity, $data) {
    $this->entity = $entity;
    $this->data = $data;
  }

  abstract public function getRules();

  public function isValid() {
    $rules = $this->getRules();
    $validator = \Validator::make($this->data, $rules);

    if ($validator->fails()) {
      throw new ValidationException("Error Processing Request", $validator->messages());    
    }

  }

  public function create() {
    $this->isValid();

    $data = $this->prepareData($this->data);
    $model = $this->entity->create($data);
    $newData = $model->toArray();
 
    $this->entity->fill($newData);
  }

  public function edit() {
    $this->isValid();
    $this->entity->fill($this->prepareData($this->data));
    $this->entity->update();
  }

  public function saveRelation() {
    $this->isValid();
    $this->entity->fill($this->prepareData($this->data));

    return $this->entity;
  }

  public function prepareData($data) {
    return $data;
  }

}