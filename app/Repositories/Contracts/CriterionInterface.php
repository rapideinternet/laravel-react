<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 12/10/17
 * Time: 9:11 AM
 */

namespace App\Repositories\Contracts;

use App\Repositories\Criteria\Criterion;
use App\Repositories\Repository;
use Illuminate\Support\Collection;

interface CriterionInterface
{
    /**
     * Skip applying the criteria
     *
     * @param bool $status
     * @return mixed
     */
    public function skipCriteria($status = true): Repository;

    /**
     * Get the collection of all criteria
     *
     * @return Collection
     */
    public function getCriteria(): Collection;

    /**
     * Get by Criterion
     *
     * @param Criterion $criteria
     * @return Repository
     */
    public function getByCriteria(Criterion $criteria): Repository;

    /**
     * Add criteria
     *
     * @param Criterion $criteria
     * @return Repository
     */
    public function pushCriteria(Criterion $criteria): Repository;


    /**
     * Apply the criteria
     *
     * @return Repository
     */
    public function applyCriteria(): Repository;
}