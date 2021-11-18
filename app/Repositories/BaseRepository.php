<?php

namespace App\Repositories;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = app()->make($this->getModel());
    }

    /**
     * get model class.
     * @return mixed
     */
    abstract public function getModel();

    public function getAll()
    {
        return $this->model->orderBy('name')->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes)
    {
        $result = $this->model->findOrFail($id);
        $result->update($attributes);

        return $result;
    }

    public function delete($id)
    {
        $result = $this->model->findOrFail($id);
        $result->delete();
    }

    public function page($amount, $filter = null)
    {
        if (isset($filter)) {
            return $this->model->ofType($filter)->paginate($amount);
        } else {
            return $this->model->latest()->paginate($amount);
        }
    }
}
