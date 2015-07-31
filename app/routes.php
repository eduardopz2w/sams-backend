<?php

// notificacion
Route::post('register/notifications', ['as' => 'add-instance', 'uses' => 'InstanceController@addInstance']);
Route::get('confirmed/notifications/{id}', ['as' => 'confirmed-instance', 'uses' => 'InstanceController@confirmedInstance']);

// elder
Route::put('edit/elder/{id}', ['as' => 'update-elder', 'uses' => 'ElderController@updateElder']);

// record
Route::post('register/record/{id}', ['as' => 'add-record', 'uses' => 'RecordController@createRecord']);


// image
Route::post('register/img/record/{id}', ['as'  => 'record-img', 'uses'   => 'ImgController@addRecordImg']);
Route::post('register/img/employee/{id}', ['as' => 'employee-img', 'uses' => 'ImgController@addEmployeeImg']);

// employee
Route::post('register/employee', ['as' => 'add-employee', 'uses' => 'EmployeeController@createEmployee']);

// occurrence
Route::post('register/occurrence/{id}', ['as' => 'occurrence', 'uses' => 'OccurrenceController@createOccurrence']);

// configuration
Route::put('configuration/edit', ['as' => 'config', 'uses' => 'ConfigurationController@config']);

// Schedule
Route::post('register/schedule/{id}', ['as' => 'schedule', 'uses' => 'ScheduleController@addSchedule']);


// permits

Route::post('register/permit/{id}', ['as' => 'add-permit', 'uses' => 'PermitController@createPermit']);










Route::get('/', function () {

	return View::make('picture');

});






// Route::get('test', function () {
//    $date = '2015-07-26';

// 	 $day = date("l",strtotime($date));

// 	 dd($day);

// });




/*Route::post('test', function () {

	$time      = Input::get('time');
	$h         = Input::get('timeH');
  
  $test = strtotime($time);
  $star = date('H:i', strtotime('-30 minutes' ,$test));
  dd($star);


	if ($h > $time)

	{
		 dd('mayor');
	}

	else

	{
			dd('no');
	}

	dd(date( $segmens[0].":".$segmens[1], strtotime('-1 hour')));
	// $timeTotal = explode(':', $time);
  
  // $test = date($time, strtotime('-10 minute'));
  // dd($test);
   dd($time);
  $test = strtotime('-10 minute' , $time);
  dd($test);

});
*/

// Route::post('test', function () {
// 	$hrsOne = Input::get('time');
// 	$hrsTwo = Input::get('timeH');

// 	$timeOne = explode(':', $hrsOne);
//   $timeTwo = explode(':', $hrsTwo);

//   $elapsedOne = ($timeOne[0] * 60) + $timeOne[1];
//   $elapsedTwo = ($timeTwo[0] * 60) + $timeTwo[1];

//   $totalElapsed = $elapsedOne - $elapsedTwo;

//   if ($totalElapsed <= 59) 
//   {
//   	dd('minutos '.$totalElapsed);
//   } 

//   else

//   {
//   		$hoursElapse = round($totalElapsed / 60);

//   		if ($hoursElapse <= 9) $hoursElapse = '0'.$hoursElapse;

//   		$minElpase = $totalElapsed % 60;

//   		if($minElpase <= 9) $minElpase = '0'.$minElpase;

//   		dd($hoursElapse.':'.$minElpase)
 

//   }


// });

// Route::post('test', function () {

// 	$arr    = Input::all();
// 	$always = array_only($arr, ['control_menu', 'max_hours', 'max_permits']);

// 	foreach ($always as $key) 
// 	{
// 			if (empty($key))

// 			{
// 				 dd('vacio');
// 			}

// 			else

// 			{
// 					dd('lleno');
// 			}
// 	}


// });



// Route::post('test', function () {

// 	$data = Input::all();

// 	$days       = array_keys($data);
// 	$values     = array_values($data);
// 	$quantity   = count($days);
// 	$first      = false;
// 	$selectDays;
   
// 	for($i = 0; $i < $quantity; $i++)

// 	{
// 		    	if (!empty($values[$i]))

// 				{   
// 					  if (!$first)

// 					  {
// 					  		$selectDays = $days[$i];
// 					  		$first = true;
// 					  }

// 					  else

// 					  {
// 					  		$selectDays .= ' '.$days[$i];
// 					  }

// 				}
// 	}

// 	dd($selectDays);


// });


// Route::get('test', function () {
//    $date = '2015-07-17';

// 	 $day = date("l",strtotime($date));

// 	 dd($day);

// });



// Route::get('t', function () {
// 	$test = 'hi.l';

// 	$conver = preg_replace('.', 'ggg', $test);

// 	dd($conver);
// });