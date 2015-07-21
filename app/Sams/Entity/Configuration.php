<?php

namespace Sams\Entity;

class Configuration extends \Eloquent {
	protected $fillable = ['name_institution', 'turn_morning', 'turn_afternoon', 'turn_night',
	                       'control_menu', 'control_employee', 'max_hours', 'max_permits'];
}