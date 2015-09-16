<?php

namespace Sams\Entity;

class Configuration extends \Eloquent {
	protected $fillable = ['name_institution', 'max_hours', 'max_permits', 'max_impeachment'];
}