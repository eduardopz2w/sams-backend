<?php

namespace Sams\Manager;

class ProductEditManager extends BaseManager {

  public function getRules() {
    $rules = [
     'description' => 'required|unique:products,description,'.$this->entity->id,
     'unit' => 'required|in:kg,und,caja,paq,bultos',
     'stock' => 'required|numeric'
    ];

    return $rules;
  }

}