<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Faker\Factory as FakerFactory;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();
        for($i = 0; $i < 50; $i++) {
            User::Create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password')
            ]);
        }
    }
} 