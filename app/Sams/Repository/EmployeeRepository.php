<?php

namespace Sams\Repository;

use Sams\Entity\Employee;

class EmployeeRepository extends BaseRepository {

	public function getModel()

	{
			return new Employee;
	}

}