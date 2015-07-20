<?php

// notificacion
Route::post('register/notifications', ['as' => 'add-instance', 'uses' => 'InstanceController@addInstance']);
Route::get('confirmed/notifications/{id}', ['as' => 'confirmed-instance', 'uses' => 'InstanceController@confirmedInstance']);

// elder
Route::put('edit/elder/{id}', ['as' => 'update-elder', 'uses' => 'ElderController@updateElder']);

// record
Route::post('register/record/{id}', ['as' => 'add-record', 'uses' => 'RecordController@createRecord']);



Route::post('register/img/record/{id}', ['as' => 'record-img', 'uses' => 'ImgController@addRecordImg']);



Route::get('/', function () {

	return View::make('picture');

});


/*Route::post('test', function () {

	$data = Input::all();

	$days       = array_keys($data);
	$values     = array_values($data);
	$quantity   = count($days);
	$first      = false;
	$selectDays;
   
	for($i = 0; $i < $quantity; $i++)

	{
		    	if (!empty($values[$i]))

				{   
					  if (!$first)

					  {
					  		$selectDays = $days[$i];
					  		$first = true;
					  }

					  else

					  {
					  		$selectDays .= ' '.$days[$i];
					  }

				}
	}

	dd($selectDays);


});*/


// Route::get('test', function () {
//    $date = '2015-07-17';

// 	 $day = date("l",strtotime($date));

// 	 dd($day);

// });



Route::get('t', function () {
	$test = 'hi.l';

	$conver = preg_replace('.', 'ggg', $test);

	dd($conver);
});