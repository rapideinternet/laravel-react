<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 12/10/17
 * Time: 9:09 AM
 */

namespace App\Repositories\Criteria;


use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Criterion
{
    /**
     * Apply search criteria
     *
     * @param $model
     * @param RepositoryInterface $repository
     * @return Model|Builder
     */
    public abstract function apply($model, RepositoryInterface $repository);
}