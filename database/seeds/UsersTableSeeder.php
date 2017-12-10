<?php

use App\Models\User;
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
        factory(User::class, 50)->create();

        User::create([
            'name' => 'Moeen Basra',
            'email' => 'm.basra@live.com',
            'password' => bcrypt('secret'),
            'is_admin' => true,
            'remember_token' => str_random(10),
        ]);
    }
}
