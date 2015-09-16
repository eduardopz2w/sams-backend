<?php

namespace Sams\Entity;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {
	protected $fillable = ['name', 'display_name'];
}