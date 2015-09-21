<?php

namespace Sams\Entity;

class Occasion extends \Eloquent {
	protected $fillable = ['name', 'description', 'entry_time', 'departure_time', 'date_start',
                         'date_end', 'id'];
}