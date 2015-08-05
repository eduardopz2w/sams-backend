<?php

use Sams\Manager\ConfigurationManager;

class ConfigurationController extends BaseController {

	public function config()

	{
			$configuration = get_configuration();
			$manager = new ConfigurationManager($configuration, Input::all());
			$manager->save();

			return Redirect::to('configuration', ['message' => 'configuracion actualizada']);
	}

	public function getConfiguration($message = null)

	{
			$config = get_configuration();

			return Response::json(['status'  => 'success',
				                     'message' => $message,
				                     'config'  => $config]);
	}

}