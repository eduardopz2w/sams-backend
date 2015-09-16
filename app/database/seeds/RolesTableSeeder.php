<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Sams\Entity\User;
use Sams\Entity\Role;


class RolesTableSeeder extends Seeder {

  public function run() {
    $admin = new Role();
    $admin->name = 'Admin';

    $admin->save();

    $user = new Role();
    $user->name = 'User';

    $user->save();

    $superAdmin = new Role();
    $superAdmin->name = 'SuperAdmin';

    $superAdmin->save();
    
    $account = User::create(['email' => 'sams@gmail.com', 'password' => 123456]);

    $account->roles()->attach($superAdmin->id);


  }
  
	  


}