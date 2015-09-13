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

    $this->entity->create($data);
    $this->entity->fill($data);

    return $this->entity;
  }

  public function edit() {
    $this->isValid();
    $this->entity->fill($this->prepareData($this->data));
    $this->entity->save();
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