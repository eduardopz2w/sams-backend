<?php

use Sams\Manager\ConfigurationManager;

class ConfigController extends BaseController {

  public function config() {
    $config = get_configuration();

    $response = [
      'status' => 'success',
      'data' => $config
    ];

    return Response::json($response);
  }

  public function edit() {
    $user = Auth::user();

    if (!$user->hasRole('SuperAdmin')) {
      $response = [
        'status' => 'error',
        'message' => 'No posee permisos para modificar las configuraciones'
      ];
    } else {
      $config = get_configuration();
      $data = Input::except('_method');
      $manager = new ConfigurationManager($config, $data);

      $manager->edit();

      $response = [
        'status' => 'success',
        'data' => $config,
        'message' => 'Datos actualizados'
      ];
    }
  
    return Response::json($response);
  }

}