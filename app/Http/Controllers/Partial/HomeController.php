<?php namespace App\Http\Controllers\Partial;


use App\Models\Article;

class HomeController
{


    public function index()
    {
        $articles = Article::all();

        return view('partial-react.index', ['articles' => $articles]);
    }
}