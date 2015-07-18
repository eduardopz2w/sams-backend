<?php

// notificacion
Route::post('register/notifications', ['as' => 'add-instance', 'uses' => 'InstanceController@addInstance']);
Route::get('confirmed/notifications/{id}', ['as' => 'confirmed-instance', 'uses' => 'InstanceController@confirmedInstance']);

// elder
Route::put('edit/elder/{id}', ['as' => 'update-elder', 'uses' => 'ElderController@updateElder']);

// record
Route::post('register/record/{id}', ['as' => 'add-record', 'uses' => 'RecordController@createRecord']);




Route::get('/', function () {

	return View::make('picture');
	
});

