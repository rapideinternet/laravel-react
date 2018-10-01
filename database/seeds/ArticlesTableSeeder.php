<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::where('is_admin', true)->first();
        factory(App\Models\Article::class, 250)->create([
            'user_id' => $user->id
        ]);
    }
}
