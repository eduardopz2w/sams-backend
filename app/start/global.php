<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

header("Access-Control-Allow-Origin: http://sams");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

App::error(function(\Sams\Manager\ValidationException $exception) {

	  return Response::json(['status'  => 'error',
	  	                     'message' => $exception->getErrors()]);

});




/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});



/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';



date_default_timezone_set("America/Caracas");


function current_date()

{
		return date('Y-m-d');
}

function first_day_month($month, $year)

{
		return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
}

function last_day_month($month, $year)

{
		return date('Y-m-d', (mktime(0, 0, 0, $month + 1, 1, $year) -1));
}

function date_day($date)

{
		$day = date('l', strtotime($date));
		return strtolower($day);
}

function add_hour($hour, $minutes)

{
		$hour = strtotime($hour);
		$minutesAdd = date('H:i', strtotime('+'.$minutes.' minutes', $hour));

		return $minutesAdd;
}

function rest_minutes($hour, $minutes)

{
		$hour = strtotime($hour);
		$minutesRest = date('H:i', strtotime('-'.$minutes.' minutes', $hour));
    
    return $minutesRest;
}

function hour_usual($hour)

{
		$minutes   = '720';
		$afternoon = '13:00';

		if ($hour >= $afternoon)

		{
				$hour = rest_minutes($hour, $minutes);
				$hour = $hour.' pm';
		}

		return $hour;
}

use Sams\Entity\Configuration;

function get_configuration()

{
		return Configuration::find(1);
}


