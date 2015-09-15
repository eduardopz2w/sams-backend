<?php

namespace Sams\Entity;

class Permit extends \Eloquent {
	protected $fillable = ['employee_id', 'reason', 'date_start', 'date_end', 
	                       'turn', 'state', 'type'];

	public function employee() {
		return $this->belongsTo('Sams\Entity\Employee');
	}
	
	public function attendances() {
		return $this->hasMany('Sams\Entity\Attendance');
	}
	
}