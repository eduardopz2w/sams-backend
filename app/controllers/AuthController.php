<?php

use Sams\Manager\AuthManager;
use Sams\Repository\UserRepository;

class AuthController extends BaseController {

	protected $userRepo;

	public function __construct(UserRepository $userRepo)

	{
			$this->userRepo = $userRepo;
	}

	public function login()

	{
			$manager = new AuthManager(Input::all());
			$manager->confirmed();

			return Redirect::to('user/authenticate');
	}

	public function getUserAutenticate()

	{
			$user = $this->userRepo->getUserLogin();

			return Response::json(['status' => 'success',
				                     'data'   => ['first_name'=> $user->first_name,
				                                  'last_name' => $user->last_name,
				                                  'email'     => $user->email,
				                                  'group'     => $user->getGroups()->first()]]);
	}

	public function logout()

	{
			Sentry::logout();
	}

}