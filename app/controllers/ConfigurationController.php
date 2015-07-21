<?php

use Sams\Manager\ConfigurationManager;

class ConfigurationController extends BaseController {

	public function config()

	{
			$configuration = get_configuration();
			$manager = new ConfigurationManager($configuration, Input::all());
			$manager->save();

			return Response::json(['status'  => 'success',
				                     'message' => 'configuracion actualizada']);
	}

}