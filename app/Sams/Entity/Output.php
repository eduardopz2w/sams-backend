<?php

namespace Sams\Entity;

class Output extends \Eloquent {
	protected $fillable = [ 'image_url', 'mime', 'hour_output', 'hour_arrival',
	                       'date_init', 'date_end', 'type', 'address', 'elder_id', 'state'];

	public function elder()

	{
			return $this->belongsTo('Sams\Entity\Elder');
	}

	public function relative()

	{
			return $this->belongsTo('Sams\Entity\Relative');
	}

	public function employee()

	{
			return $this->belongsTo('Sams\Entity\Employee');
	}


}