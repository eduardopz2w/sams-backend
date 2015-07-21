<?php

namespace Sams\Entity;

class Occurrence extends \Eloquent {
	protected $fillable = ['elder_id', 'location', 'case_situation'];

	public function elder()

	{
			return $this->belongsTo('Sams\Entity\Elder');
	}
}