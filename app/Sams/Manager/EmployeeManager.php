<?php

namespace Sams\Manager;

class EmployeeManager extends BaseManager {

	public function confirmEmployee()

	{
			$this->save();
			return $this->entity->id;
	}
	
	public function prepareData($data)

	{
			$data['activiti'] = 1;
			$this->assignUrl($data);
			return $data;
	}

	public function assignUrl(&$data)

	{
		 $path = public_path().'\image\geriatric';

			if ($data['gender'] == 'm')	
			
			{
					$data['image_url'] =  $path.'\profile.default_man.jpg';
			}

			else

			{
					$data['image_url'] = $path.'\profile.default_woman.jpg';
			}

			$data['mime'] = 'jpg';
	}

}