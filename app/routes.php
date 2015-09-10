<?php

// configuration
Route::get('configuration/{message?}', 'ConfigurationController@getConfiguration');

//auth
Route::post('login', ['as'  => 'login', 'uses'  => 'AuthController@login']);
Route::get('logout' , ['as' => 'logout', 'uses' => 'AuthController@logout']);


Route::group(['before' => 'auth-sentry'], function ()
{

  // notificacion
	Route::post('instance/register', ['as' => 'add-instance', 'uses' => 'InstanceController@create']);
	Route::get('instance/{id}/confirmed', ['as' => 'confirmed-instance', 'uses' => 'InstanceController@confirmedInstance']);
	Route::get('waiting/notifications/{id}', ['as' => 'waiting-instance', 'uses' => 'InstanceController@instanceWaiting']);
	// elder
  Route::put('elder/edit/{id}', ['as' => 'elder-edit', 'uses' => 'ElderController@edit']);
  Route::get('elders/{state}', ['as' => 'elders', 'uses' => 'ElderController@elders']);
  Route::get('elder/{id}', ['as' => 'elder', 'uses' => 'ElderController@elder']);
  // record
	Route::post('record/{elderId}/register', ['as' => 'add-record', 'uses' => 'RecordController@create']);
  Route::get('show/record/{id}/{idRecord}', ['as' => 'show-record', 'uses' => 'RecordController@showRecord']);
  Route::put('edit/record/{id}', ['as' => 'edit-record', 'uses' => 'RecordController@editRecord']);
  Route::get('state/record/{id}', ['as' => 'state-record', 'uses' => 'RecordController@stateRecord']);
	// employee
	Route::post('employee/register', ['as' => 'employee-add', 'uses' => 'EmployeeController@create']);
  Route::put('employee/{id}/edit', ['as' => 'employee-edit','uses' => 'EmployeeController@edit']);
  Route::get('employee/{id}', ['as' => 'employee', 'uses' => 'EmployeeController@show']);
  Route::get('employee/{id}/attendances', ['as' => 'employee-attendances', 'uses' => 'EmployeeController@getAttendances']);


	//occurrence
	Route::post('register/occurrence/{id}', ['as' => 'occurrence', 'uses' => 'OccurrenceController@createOccurrence']);
  // configuration
	Route::put('configuration/edit', ['as' => 'config', 'uses' => 'ConfigurationController@config']);
  // schedule
	Route::post('register/employee/schedule/{id}', ['as' => 'schedule-addemployee', 'uses' => 'ScheduleController@addScheduleEmployee']);
	Route::post('register/action/schedule/{id}', ['as' => 'schedule-addaction', 'uses' => 'ScheduleController@addScheduleAction']);
  Route::get('schedule/{id}/employee/{employeeId}', ['as' => 'schedule-employee', 'uses' => 'ScheduleController@getScheduleEmp']);
  Route::post('schedule/{id}/employee/{employeeId}/remove', ['as' => 'schedule-removeEmp', 'uses' => 'ScheduleController@removeScheduleEmp']);
  // permit
	Route::post('permit/register/{employeeId}', ['as' => 'add-permit', 'uses' => 'PermitController@createPermit']);
	// attendance 
	Route::get('attendances', ['as' => 'attendance', 'uses' => 'AttendanceController@attendances']);
  Route::get('attendances/{id}/confirmed', ['as' => 'attendance-add', 'uses' => 'AttendanceController@confirmed']);
  Route::get('attendances/waiting', ['as' => 'attendance-waiting', 'uses' => 'AttendanceController@attendanceWaiting']);
  Route::put('attendances/{id}/edit', ['as' => 'attendance-edit', 'uses' => 'AttendanceController@edit']);
  // auth
  Route::get('user/authenticate', 'AuthController@getUserAutenticate');
  // citation 
  Route::post('register/citation/{id}', 'CitationController@createCitation');
	Route::post('confirmed/citation/{id}/{confirmed?}/{notificacion?}', ['as' => 'confirmed-citation', 'uses' => 'CitationController@confirmedCitation']);
	Route::get('citations/{date}', ['as' => 'day-citation', 'uses' => 'CitationController@citationDate']);
  Route::get('citations/hour/day', ['as' => 'hour-citation', 'uses' => 'CitationController@citationHour']);
  // action
  Route::post('action/register', ['as' => 'action-register', 'uses' => 'ActionController@register']);
  Route::get('action/all', ['as' => 'action-all', 'uses' => 'ActionController@actions']);
  Route::get('action/all/{date}', ['as' => 'action-date', 'uses' => 'ActionController@getForDate']);
  Route::get('action/{id}', ['as' => 'action', 'uses' => 'ActionController@show']);
  Route::put('action/{id}/edit', ['as' => 'action', 'uses' => 'ActionController@edit']);
  Route::get('action/{id}/schedules', ['as' => 'action-schedules', 'uses' => 'ActionController@getSchedules']);
  Route::get('action/{id}/schedules/{scheduleId}/remove', ['as' => 'remove-schedule', 'uses' => 'ActionController@removeSchedule']);
  Route::get('action/{id}/state', ['as' => 'action-state', 'uses' => 'ActionController@state']);
  Route::delete('action/{id}/delete', ['as' => 'action-delete', 'uses' => 'ActionController@delete']);
  
  //Occasion
  Route::post('occasion/register', ['as' => 'occasion-register', 'uses' => 'OccasionController@register']);
  Route::get('occasion/all', ['as' => 'occasion-date', 'uses' => 'OccasionController@getForDate']);
  Route::get('occasion/{id}', ['as' => 'occasion-show', 'uses' => 'OccasionController@show']);
  Route::put('occasion/{id}/edit', ['as' => 'occasion-edit', 'uses' => 'OccasionController@edit']);
  Route::delete('occasion/{id}/delete', ['as' => 'occasion-delete', 'uses' => 'OccasionController@delete']);
  // relative
  Route::post('register/relative', ['as' => 'add-relative', 'uses' => 'RelativeController@createRelative']);
  // output
  Route::post('register/output', ['as' => 'add-output', 'uses' => 'OutputController@createOutput']);
  // search smart
  Route::get('search/elders', ['as' => 'search-elders', 'uses' => 'SearchController@searchElder']);
});




Route::get('/', function () {
	return View::make('picture');
});







// Route::get('test', function () {
//   $hourIn = '1:00';
//   $hourOut = '1:59';

//   if ($hourIn > $hourOut) {
//     dd('hour in');
//   } else{
//     dd('hour out');
//   }
// });

// Route::get('test', function () {
//   $filename = uniqid('MyApp', true) . '.pdf';
//   dd($filename);
// });

// Route::get('test', function () {
// 	dd(public_path());
// 	// dd(app_path());
// });


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