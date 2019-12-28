<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        // factory('App\User', 1)->create();
        factory('App\Produs', 50)->create();
        factory('App\ProdusVandut', 500)->create();
    }
}
