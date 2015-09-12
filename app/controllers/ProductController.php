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

  public function all() {
    $products = $this->productRepo->getProducts();

    $this->productTask->confirmProducts($products);

    $response = [
      'status' => 'success',
      'data' => $products
    ];

    return Response::json($response);
  }

  public function register() {
    $product = $this->productRepo->getModel();
    $data = Input::all();
    $manager = new ProductManager($product, $data);

    $manager->save();

    $response = [
      'status' => 'success',
      'message' => 'Producto registrado'
    ];

    return Response::json($response);
  }

  public function show($id) {
    $product = $this->productRepo->find($id);

    $this->notFound($product);

    $response = [
      'status' => 'success',
      'data' => $product
    ];

    return Response::json($response);
  }

  public function edit($id) {
    $product = $this->productRepo->find($id);
    $data = Input::all();
    $manager = new ProductEditManager($product, $data);

    $manager->save();

    $response = [
      'status' => 'success',
      'message' => 'Datos actualizados'
    ];

    return Response::json($response);
  }

  public function delete($id) {
    $product = $this->productRepo->find($id);

    $product->delete();

    $response = [
      'status' => 'success',
      'message' => 'Producto eliminado'
    ];

    return Response::json($response);
  }

}