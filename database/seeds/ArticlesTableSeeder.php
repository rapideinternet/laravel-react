<?php

use App\Models\Article;
use App\Models\User;
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
        $user = User::where('is_admin', true)->first();
        factory(Article::class, 250)->create([
            'user_id' => $user->id
        ]);
    }
}
