<?php

namespace Sams\Entity;

use Zizaco\Entrust\HasRole;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	 /**
    * The attributes that are mass assignable.
    *
    * @var array
    */

	protected $fillable = ['email', 'password'];

	public function setPasswordAttribute($value) {
		if (!empty($value)) {
			$this->attributes['password'] = \Hash::make($value);
		}
	}

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function loadRole() {
		if ($this->hasRole('Admin')) {
			$this->role = 'Admin';
		} elseif ($this->hasRole('SuperAdmin')) {
			$this->role = 'SuperAdmin';
		} else {
			$this->role = 'User';
		}
	}

	public function employee() {
		return $this->belongsTo('Sams\Entity\Employee');
	}

}
