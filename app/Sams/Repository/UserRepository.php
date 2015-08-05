<?php

namespace Sams\Repository;

class UserRepository {

	public function getUserLogin()

	{
			return \Sentry::getUser();
	}

}