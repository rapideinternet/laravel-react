<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\RepositoryInterface;
use App\Exceptions\RepositoryException;
use App\Repositories\Contracts\CriterionInterface;
use App\Repositories\Criteria\Criterion;

/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface, CriterionInterface
{

    /**
     * @var App
     */
    private $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Model
     */
    protected $newModel;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * Prevents from overwriting same criteria in chain usage
     * @var bool
     */
    protected $preventCriteriaOverwriting = true;

    /**
     * @param App $app
     * @param Collection $collection
     * @throws RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public abstract function model();

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel(): Model
    {
        return $this->setModel($this->model());
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $model
     * @return Model
     * @throws RepositoryException
     */
    public function setModel($model): Model
    {
        $this->newModel = $this->app->make($model);

        if (!$this->newModel instanceof Model)
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $this->newModel;
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ["*"]): Collection
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param  string $value
     * @param  string $key
     * @return array
     */
    public function lists($value, $key = null)
    {
        $this->applyCriteria();
        $lists = $this->model->lists($value, $key);
        if (is_array($lists)) {
            return $lists;
        }
        return $lists->all();
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 25, array $columns = ["*"]): LengthAwarePaginator
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function fill(array $data): Model
    {
        return $this->model->fill($data);
    }

    /**
     * save a model without massive assignment
     *
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data)
    {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }
        return $this->model->save();
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return bool
     */
    public function update(int $id, array $data, $attribute = "id"): bool
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param  array $data
     * @param  $id
     * @return mixed
     */
    public function updateRich(array $data, $id)
    {
        if (!($model = $this->model->find($id))) {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ["*"]): Model
    {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy(string $attribute, string $value, array $columns = ["*"]): Model
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $or = false)
    {
        $this->applyCriteria();

        $model = $this->model;

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }
        return $model->get($columns);
    }

    /**
     * @return $this
     */
    public function resetScope(): Repository
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true): Repository
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * @param Criterion $criterion
     * @return $this
     */
    public function getByCriteria(Criterion $criterion): Repository
    {
        $this->model = $criterion->apply($this->model, $this);
        return $this;
    }

    /**
     * @param Criterion $criterion
     * @return $this
     */
    public function pushCriteria(Criterion $criterion): Repository
    {
        if ($this->preventCriteriaOverwriting) {
            // Find existing criteria
            $key = $this->criteria->search(function ($item) use ($criterion) {
                return (is_object($item) && (get_class($item) == get_class($criterion)));
            });

            // Remove old criteria
            if (is_int($key)) {
                $this->criteria->offsetUnset($key);
            }
        }

        $this->criteria->push($criterion);
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria(): Repository
    {
        if (true === $this->skipCriteria)
            return $this;

        foreach ($this->getCriteria() as $criterion) {
            if ($criterion instanceof Criterion) {
                $this->model = $criterion->apply($this->model, $this);
            }
        }

        return $this;
    }
}