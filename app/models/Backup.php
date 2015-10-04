<?php

class Backup extends \Eloquent {
	protected $fillable = [];

  public function getDateTimeString() {
    $date = new DateTime($this->created_at);
    return $date->format('Y_m_d_His');
  }
  public function setPrettyName() {
    $this->name = $this->getDateTimeString().'.sql';
  }
}