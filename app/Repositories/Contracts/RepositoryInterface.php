<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 12/9/17
 * Time: 5:02 PM
 */

namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * fetch all records
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * fetch and paginate records
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * fetch one by id
     *
     * @param int $id
     * @param array $columns
     * @return Model
     */
    public function find(int $id, array $columns = ['*']): Model;

    /**
     * fetch by field and value
     *
     * @param string $attribute
     * @param string $value
     * @param array $columns
     * @return Model
     */
    public function findBy(string $attribute, string $value, array $columns = ['*']): Model;

    /**
     * create a new record
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * update existing record
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Fill data into the model attributes
     *
     * @param array $data
     * @return Model
     */
    public function fill(array $data): Model;

    /**
     * Remove a record
     *
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}