<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Andrei Dima',
            'email' => 'adima@validsoftware.ro',
            'password' => bcrypt('87ujhrefdc3e4'),
        ]);
        $user->save();

        $user = \App\User::create([
            'name' => 'GS Mobile',
            'email' => 'gs@mobile',
            'password' => bcrypt('1qaz2wsx'),
        ]);
        $user->save();
    }
}
