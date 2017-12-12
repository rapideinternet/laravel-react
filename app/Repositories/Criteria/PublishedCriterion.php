<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 12/10/17
 * Time: 9:43 AM
 */

namespace App\Repositories\Criteria;


use App\Repositories\Contracts\RepositoryInterface;

class PublishedCriterion extends Criterion
{

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('published', true)
            ->whereDate('published_at', '<=', now());
    }
}