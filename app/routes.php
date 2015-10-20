<?php

// configuration
Route::get('config', 'ConfigController@config');
Route::resource('backups', 'BackupsController');

Route::post('user/login', ['as' => 'login', 'uses' => 'UserController@login']);
Route::get('user/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);

Route::group(['before' => 'auth-check'], function ()
{
  Route::group(['before' => 'isAdmin'], function () {
    // Audit
    Route::get('audits', ['as' => 'getAudit', 'uses' => 'AuditController@getAudit']);

   // employee
    Route::get('employees', ['as' => 'employees', 'uses' => 'EmployeeController@employees']);
    Route::post('employee', ['as' => 'employee-create', 'uses' => 'EmployeeController@create']);
    Route::get('employee/{id}', ['as' => 'employee->show', 'uses' => 'EmployeeController@show']);
    Route::put('employee/{id}/edit', ['as' => 'employee-edit','uses' => 'EmployeeController@edit']);
    Route::delete('employee/{id}/delete', ['as' => 'employee-delete', 'uses' => 'EmployeeController@delete']);
    Route::put('employee/{employeeId}/attendance/{attendanceId}/edit', ['as' => 'attendance-edit', 'uses' => 'AttendanceController@edit']);
    
    // schedule
    Route::post('employee/{employeeId}/schedule', ['as' => 'schedule-addEmployee', 'uses' => 'ScheduleController@addScheduleEmployee']);
    Route::get('employee/{employeeId}/schedules', ['as' => 'schedules-employee', 'uses' => 'ScheduleController@schedulesEmployee']);
    Route::get('employee/{employeeId}/schedule/{scheduleId}', ['as' => 'schedule-showEmployee', 'uses' => 'ScheduleController@showScheduleEmployee']);
    Route::get('employee/{employeeId}/schedule/{scheduleId}/remove', ['as' => 'schedule-removeEmployee', 'uses' => 'ScheduleController@removeScheduleEmployee']);

     // permit
    Route::post('employee/{employeeId}/permit', ['as' => 'permit-create', 'uses' => 'PermitController@create']);
    Route::get('employee/{employeeId}/permit/{permitId}', ['as' => 'permit-show', 'uses' => 'PermitController@show']);
    Route::get('employee/{employeeId}/permits', ['as' => 'permit-employees', 'uses' => 'PermitController@permitForEmployee']);
    Route::get('employee/{employeeId}/permit/{permitId}/cancel', ['as' => 'permit-cancel', 'uses' => 'PermitController@cancel']);
    Route::delete('employee/{employeeId}/permit/{permitId}/delete', ['as' => 'permit-delete', 'uses' => 'PermitController@delete']);
    
    // configuration
    Route::put('config/edit', ['as' => 'config', 'uses' => 'ConfigController@edit']);

    // user
    Route::post('employee/{employeeId}/user', ['as' => 'user-create', 'uses' => 'UserController@create']);
    Route::get('employee/{employeeId}/user/show', ['as' => 'user-show', 'uses' => 'UserController@show']);
    Route::put('employee/{employeeId}/user/{userId}/edit', ['as' => 'user-edit', 'uses' => 'UserController@edit']);
    Route::delete('employee/{employeeId}/user/{userId}/delete', ['as' => 'uses-delete', 'uses' => 'UserController@delete']);

    // elder
    Route::get('elder/{id}/confirmed', ['as' => 'elder-confirmed', 'uses' => 'ElderController@confirm']);
  });

  // elder
  Route::get('elder/{id}', ['as' => 'elder-show', 'uses' => 'ElderController@show']);
  Route::put('elder/{id}/edit', ['as' => 'elder-edit', 'uses' => 'ElderController@edit']);
  Route::delete('elder/{id}/delete', ['as' => 'elder-delete', 'uses' => 'ElderController@delete']);
  Route::get('elders/search', ['as' => 'elder-search', 'uses' => 'ElderController@search']);
  Route::get('elders/{state}', ['as' => 'elders', 'uses' => 'ElderController@elders']);

  // notificacion
	Route::post('elder/instance', ['as' => 'instance-create', 'uses' => 'InstanceController@create']);
  Route::get('elder/{elderId}/instance/waiting', ['as' => 'instance-waiting', 'uses' => 'InstanceController@instanceWaitingElder']);
  Route::get('elder/{elderId}/instance/{instanceId}', ['as' => 'instance-show', 'uses' => 'InstanceController@show']);
  Route::get('elder/{elderId}/instance/{instanceId}/confirmed', ['as' => 'instance-confirmed', 'uses' => 'InstanceController@confirmed']);
  Route::put('elder/{elderId}/instance/{instanceId}/edit', ['as' => 'instance-edit', 'uses' => 'InstanceController@edit']);
  Route::delete('elder/{elderId}/instance/{instanceId}/delete', ['as' => 'instance-delete', 'uses' => 'InstanceController@delete']);
  Route::get('elder/{elderId}/instances', ['as' => 'instances-elder', 'uses' => 'InstanceController@instancesElder']);
  Route::get('instances', ['as' => 'instances-date', 'uses' => 'InstanceController@instancesForDate']);
	Route::get('instances/waiting', ['as' => 'instances-waiting', 'uses' => 'InstanceController@instancesWaiting']);

  // record
  Route::post('elder/{elderId}/record', ['as' => 'record-create', 'uses' => 'RecordController@create']);
  Route::get('elder/{elderId}/records', ['as' => 'records-elder', 'uses' => 'RecordController@recordsForElder']);
  Route::get('elder/{elderId}/record/state', ['as' => 'record-state', 'uses' => 'RecordController@state']);
  Route::get('elder/{elderId}/record/{recordId}', ['as' => 'record-show', 'uses' => 'RecordController@show']);
  Route::put('elder/{elderId}/record/{recordId}/edit', ['as' => 'record-edit', 'uses' => 'RecordController@edit']);
  Route::delete('elder/{elderId}/record/{recordId}/delete', ['as' => 'record-delete', 'uses' => 'RecordController@delete']);
  
   // citation 
  Route::post('elder/{elderId}/citation', ['as' => 'citation-create', 'uses' => 'CitationController@create']);
  Route::get('elder/{elderId}/citations', ['as' => 'citation-all', 'uses' => 'CitationController@citationsForElder']);
  Route::get('elder/{elderId}/citations/waiting', ['as' => 'citation-waiting', 'uses' => 'CitationController@citationsForElderWaiting']);
  Route::get('elder/{eldeId}/citation/{citationId}', ['as' => 'citation-show', 'uses' => 'CitationController@show']);
  Route::put('elder/{elderId}/citation/{citationId}/edit', ['as' => 'citation-edit', 'uses' => 'CitationController@edit']);
  Route::get('elder/{elderId}/citation/{citationId}/check', ['as' => 'citation->confirmed', 'uses' => 'CitationController@confirmed']);
  Route::delete('elder/{elderId}/citation/{citationId}/delete', ['as' => 'citation-delete', 'uses' => 'CitationController@delete']);
  Route::get('citations/current', ['as' => 'citation-current', 'uses' => 'CitationController@citationsCurrent']);

  //occurrence
  Route::post('elder/{elderId}/occurrence', ['as' => 'occurrence-create', 'uses' => 'OccurrenceController@create']);
  Route::get('elder/{elderId}/occurrences', ['as' => 'occurrence-elder', 'uses' => 'OccurrenceController@occurrencesForElder']);
  Route::get('elder/{elderId}/occurrence/{occurrenceId}', ['as' => 'occurrence-show', 'uses' => 'OccurrenceController@show']);
  Route::put('elder/{elderId}/occurrence/{occurrenceId}/edit', ['as' => 'occurrence-edit', 'uses' => 'OccurrenceController@edit']);
  Route::delete('elder/{elderId}/occurrence/{occurrenceId}/delete', ['as' => 'occurrence-delete', 'uses' => 'OccurrenceController@delete']);
  
 // output
  Route::post('elder/{elderId}/output', ['as' => 'output-create', 'uses' => 'OutputController@create']);
  Route::get('elder/{elderId}/outputs', ['as' => 'outputs-elder', 'uses' => 'OutputController@outputsForElder']);
  Route::get('elder/{elderId}/output/pending', ['as' => 'output-pending', 'uses' => 'OutputController@outputPending']);
  Route::get('elder/{elderId}/output/{outputId}', ['as' => 'output-show', 'uses' => 'OutputController@show']);
  Route::get('elder/{elderId}/output/{outputId}/confirmed', ['as' => 'output-confirmed', 'uses' => 'OutputController@confirmed']);
  Route::put('elder/{elderId}/output/{outputId}/edit', ['as' => 'output-edit', 'uses' => 'OutputController@edit']);
  Route::delete('elder/{elderId}/output/{outputId}/delete', ['as' => 'output-delete', 'uses' => 'OutputController@delete']);
  Route::get('outputs/waiting', ['as' => 'outputs-waiting', 'uses' => 'OutputController@getOutputWaiting']);
  Route::get('outputs/{type}', ['as' => 'outputs-type', 'uses' => 'OutputController@getOutputType']);

  // attendance 
  Route::get('attendances', ['as' => 'attendance', 'uses' => 'AttendanceController@attendances']);
  Route::get('attendances/waiting', ['as' => 'attendance-waiting', 'uses' => 'AttendanceController@attendancesWaiting']);
  Route::get('employee/{employeeId}/attendances', ['as' => 'attendances-employee', 'uses' => 'AttendanceController@assistanceForEmployee']);
  Route::get('employee/{employeeId}/attendance/{attendanceId}/confirmed', ['as' => 'attendance-confirmed', 'uses' => 'AttendanceController@confirmed']);
  
  // schedule
  Route::post('action/{actionId}/schedule', ['as' => 'schedule-action', 'uses' => 'ScheduleController@addScheduleAction']);
  Route::get('action/{actionId}/schedule/{scheduleId}/remove', ['as' => 'schedule-removeAction', 'uses' => 'ScheduleController@removeScheduleAction']);
  Route::get('action/{actionId}/schedules', ['as' => 'schedules-action', 'uses' => 'ScheduleController@schedulesAction']);
  
  // action
  Route::post('action', ['as' => 'action-create', 'uses' => 'ActionController@create']);
  Route::get('actions', ['as' => 'actions', 'uses' => 'ActionController@actions']);
  Route::get('actions/today', ['as' => 'actions-today', 'uses' => 'ActionController@actionsToday']);
  Route::get('action/{actionId}', ['as' => 'action-show', 'uses' => 'ActionController@show']);
  Route::get('action/{actionId}/state', ['as' => 'action-state', 'uses' => 'ActionController@state']);
  Route::put('action/{actionId}/edit', ['as' => 'action-edit', 'uses' => 'ActionController@edit']);
  Route::delete('action/{actionId}/delete', ['as' => 'action-delete', 'uses' => 'ActionController@delete']);
 
  //Occasion
  Route::post('occasion', ['as' => 'occasion-create', 'uses' => 'OccasionController@create']);
  Route::get('occasions', ['as' => 'occasion-date', 'uses' => 'OccasionController@getForDate']);
  Route::get('occasion/{id}', ['as' => 'occasion-show', 'uses' => 'OccasionController@show']);
  Route::put('occasion/{occasionId}/edit', ['as' => 'occasion-edit', 'uses' => 'OccasionController@edit']);
  Route::delete('occasion/{id}/delete', ['as' => 'occasion-delete', 'uses' => 'OccasionController@delete']);
 
  //Product
  Route::post('product', ['as' => 'product-create', 'uses' => 'ProductController@create']);
  Route::get('products', ['as' => 'product-all', 'uses' => 'ProductController@products']);
  Route::get('product/{productId}', ['as' => 'product-show', 'uses' => 'ProductController@show']);
  Route::put('product/{productId}/edit', ['as' => 'product-edit', 'uses' => 'ProductController@edit']);
  Route::delete('product/{productId}/delete', ['as' => 'product-delete', 'uses' => 'ProductController@delete']);

  // User
  Route::get('user/logged', ['as' => 'user-logger', 'uses' => 'UserController@logged']);
  Route::get('users', ['as' => 'users', 'uses' => 'UserController@users']);
});













