<?php

namespace Sams\Entity;

class Permit extends \Eloquent {
	protected $fillable = ['employee_id', 'reason', 'date_star', 'date_end', 
	                       'turn', 'state', 'type'];

	public function employee()

	{
			return $this->belongsTo('Sams\Entity\Employee');
	}

	public function attendances()

	{
			return $this->morphMany('Sams\Entity\Attendance', 'notifying');
	}
}