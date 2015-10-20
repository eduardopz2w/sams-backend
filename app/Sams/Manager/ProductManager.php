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

  public function getMessages() {
    $messages = [
      'description.required' => 'Ingrese descripcion del producto',
      'descricion.unique' => 'Ya hay otro producto con esta descripcion',
      'unit.required' => 'Ingrese unidad',
      'unit.in' => 'Unidad ingresada es inválido',
      'stock.required' => 'Ingrese cantidad en existencia',
      'stock.numeric' => 'Cantidad en existencia debe ser un numero'
    ];

    return $messages;
  }

}