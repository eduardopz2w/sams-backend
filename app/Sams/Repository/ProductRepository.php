<?php

namespace Sams\Repository;

use Sams\Entity\Product;

class ProductRepository extends BaseRepository {

  public function getModel() {
    return new Product;
  }

  public function getProducts() {
    return Product::all();
  }

}