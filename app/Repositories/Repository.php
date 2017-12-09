<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 12/9/17
 * Time: 5:18 PM
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface
{

    /**
     * @var App
     */
    private $app;

    protected $model;

    /**
     * Repository constructor.
     *
     * @param App $app
     * @throws \Exception
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify model
     *
     * @return mixed
     */
    abstract function model();

    /**
     * assign repository a model
     *
     * @return Model|mixed
     * @throws \Exception
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("class {$this->model()} must be an instance of Illuminate\Database\Eloquent\Model");
        }

        return $this->model = $model;
    }

    /**
     * fetch all records
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->get();
    }

    /**
     * fetch and paginate records
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * fetch one by id
     *
     * @param int $id
     * @param array $columns
     * @return Model
     */
    public function find(int $id, array $columns = ['*']): Model
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * fetch by field and value
     *
     * @param string $field
     * @param string $value
     * @param array $columns
     * @return Model
     */
    public function findBy(string $field, string $value, array $columns = ['*']): Model
    {
        $this->model->where($field, $value)->get();
    }

    /**
     * create a new record
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * update existing record
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Remove a record
     *
     * @param int $id
     * @return Model
     */
    public function delete(int $id): Model
    {
        $this->model->delete($id);
    }
}