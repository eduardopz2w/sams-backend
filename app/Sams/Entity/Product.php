<?php

namespace Sams\Entity;

class Product extends \Eloquent {
	protected $fillable = ['description', 'unit', 'stock'];
}