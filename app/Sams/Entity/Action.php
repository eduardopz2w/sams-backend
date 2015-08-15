<?php

namespace Sams\Entity;

class Action extends \Eloquent {
	protected $fillable = ['employee_id' ,'description', 'type', 'responsible',
	                       'date_day', 'hour_in', 'hour_out', 'state'];

	public function employee()

	{
		 return $this->belongsTo('Sams\Entity\Employee');
	}

	public function schedules()

	{
			return $this->belongsToMany('Sams\Entity\Schedule')->withTimestamps();
	}

}