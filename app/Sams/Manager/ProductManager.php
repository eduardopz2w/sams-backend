<?php

namespace Sams\Manager;

class ProductManager extends BaseManager {

  public function getRules() {
    $rules = [
     'description' => 'required|unique:products,description',
     'unit' => 'required|in:kg,und,caja,paq,bultos',
     'stock' => 'required|numeric'
    ];

    return $rules;
  }

}