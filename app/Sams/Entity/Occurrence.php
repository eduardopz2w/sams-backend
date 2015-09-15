<?php

namespace Sams\Entity;

class Occurrence extends \Eloquent {
	protected $fillable = ['case_situation', 'image_url', 'mime', 'date'];

	public function elder()

	{
			return $this->belongsTo('Sams\Entity\Elder');
	}
}