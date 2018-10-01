<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 50)->create();

        \App\Models\User::create([
            'name' => 'rapide',
            'email' => 'test@rapide.nl',
            'password' => bcrypt('secret'),
            'is_admin' => true,
            'remember_token' => str_random(10),
        ]);
    }
}
