<?php

use Sams\Manager\ProductManager;
use Sams\Manager\ProductEditManager;
use Sams\Repository\ProductRepository;
use Sams\Task\ProductTask;

class ProductController extends BaseController {

  protected $productRepo;
  protected $productTask;

  public function __construct(ProductRepository $productRepo,
                              ProductTask $productTask) {
    $this->productRepo = $productRepo;
    $this->productTask = $productTask;
  }

  public function create() {
    $product = $this->productRepo->getModel();
    $data = Input::all();
    $manager = new ProductManager($product, $data);

    $manager->create();

    $response = [
      'status' => 'success',
      'message' => 'Producto registrado'
    ];

    return Response::json($response);
  }

  public function products() {
    $products = $this->productRepo->getProducts();

    $this->productTask->confirmProducts($products);

    $response = [
      'status' => 'success',
      'data' => $products
    ];

    return Response::json($response);
  }

  public function show($productId) {
    $product = $this->productRepo->find($productId);

    $this->notFound($product);

    $response = [
      'status' => 'success',
      'data' => $product
    ];

    return Response::json($response);
  }

  public function edit($productId) {
    $product = $this->productRepo->find($productId);
    $data = Input::all();
    $manager = new ProductEditManager($product, $data);

    $manager->edit();

    $response = [
      'status' => 'success',
      'message' => 'Datos actualizados',
      'data' => $product
    ];

    return Response::json($response);
  }

  public function delete($productId) {
    $product = $this->productRepo->find($productId);

    $product->delete();

    $response = [
      'status' => 'success',
      'message' => 'Producto eliminado'
    ];

    return Response::json($response);
  }

}