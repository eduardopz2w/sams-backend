<?php

namespace Sams\Manager;

class EmployeeManager extends BaseManager {

	public function prepareData($data)

	{
			$data['activiti'] = 1;
			return $data;
	}

}