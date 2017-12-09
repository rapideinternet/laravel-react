<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 12/9/17
 * Time: 4:23 PM
 */

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository extends Repository
{
    /**
     * Specify model
     *
     * @return mixed
     */
    function model()
    {
        return Article::class;
    }
}