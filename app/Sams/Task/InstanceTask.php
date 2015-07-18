<?php

namespace Sams\Task;

class InstanceTask {

	public function confirmInstance($instance)

	{
			$instance->admission_date = current_date();
			$instance->state = 'confirmed';
			$instance->save();

			$this->confirmedElder($instance);
	}

	public function confirmedElder($instance)

	{
			$elder = $instance->elder;
			$elder->activiti = 1;
			$elder->save();
	}

}