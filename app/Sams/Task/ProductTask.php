<?php

namespace Sams\Task;

class ProductTask extends BaseTask {

  public function confirmProducts($products) {
    $count = count($products);

    if ($count == 0) {
      $message = 'No hay productos registrados';

      $this->hasException($message);
    }
  }
}