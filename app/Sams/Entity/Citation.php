<?php
namespace Sams\Entity;

class Citation extends \Eloquent {
	protected $fillable = ['elder_id', 'state', 'address', 'date_day', 'hour',
	                       'reason'];

	public function elder()

	{
			return $this->belongsTo('Sams\Entity\Elder');
	}

	public function reference()

	{
			return $this->hasOne('Sams\Entity\Reference');
	}

	public function getHourUsualAttribute()

	{
			$hour = $this->hour;
			$hour = hour_usual($hour);
			
			return $hour;
	}

	public function getStateEntryAttribute()

	{
			return \Lang::get('utils.state_citation.'.$this->state);
	}
}