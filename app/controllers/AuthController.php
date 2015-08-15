<?php

use Sams\Manager\AuthManager;
use Sams\Repository\UserRepository;
use Sams\Repository\InstanceRepository;
use Sams\Repository\CitationRepository;

class AuthController extends BaseController {

	protected $userRepo;
	protected $instanceRepo;
	protected $citationRepo;

	public function __construct(UserRepository $userRepo, InstanceRepository $instanceRepo,
	                            CitationRepository $citationRepo)

	{
			$this->userRepo     = $userRepo;
			$this->instanceRepo = $instanceRepo;
			$this->citationRepo = $citationRepo;
	}

	public function login()

	{
			$manager = new AuthManager(Input::all());
			
			$manager->confirmed();

			return Redirect::to('user/authenticate');
	}

	public function getUserAutenticate()

	{
			$user      = $this->userRepo->getUserLogin();
			$citation  = $this->citationRepo->getCitationsCurrent();
			$instances = $this->instanceRepo->getInstanceVisited();

			return Response::json(['status' => 'success',
				                     'data'   => ['first_name'=> $user->first_name,
				                                  'last_name' => $user->last_name,
				                                  'email'     => $user->email,
				                                  'group'     => $user->getGroups()->first(),
				                                  'visited'   => $instances->count(),
				                                  'citation'  => $citation->count(),
				                                  'outputs'   => 0],
				                                  ]);
	}

	public function logout()

	{
			Sentry::logout();
	}

}