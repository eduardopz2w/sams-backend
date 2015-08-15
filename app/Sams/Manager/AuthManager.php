<?php

namespace Sams\Manager;

class AuthManager {

	public function __construct($data)

	{
			$this->data = $data;
	}

	public function confirmed()

	{
			$this->authenticate();
	}

	public function authenticate()

	{
			$credentials = $this->getCredentials();

			try
      
      {
          return \Sentry::authenticateAndRemember($credentials);
      }

      catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
			
			{
   				$message = 'Login requerido';
   				$this->hasException($message);
			}

			catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
			
			{
   				$message = 'Password requerido';
   				$this->hasException($message);
			}

      catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
      
      {
      	  $message = 'Contraseña incorrecta, vuelva a intentarlo';
          $this->hasException($message);
          
      }

      catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
      
      {
      	  $message = 'Usuario no registrado';
          $this->hasException($message);
          
      }
	}

	public function getCredentials()

	{
			$data = $this->data;

		  $credentials = [
          'email'    => $data['email'],
          'password' => $data['password'],
      ];

      return $credentials;
	}

	public function hasException($message)

	{
			throw new ValidationException("Error Processing Request", $message);
			
	}

}