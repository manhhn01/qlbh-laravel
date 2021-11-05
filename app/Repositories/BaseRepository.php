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
     * get model class
     * @return mixed
     */
    public abstract function getModel();


    function getAll()
    {
        return $this->model->orderBy('name')->get();
    }

    function find($id)
    {
        return $this->model->find($id);
    }

    function create($attributes)
    {
        return $this->model->create($attributes);
    }

    function update($id, $attributes)
    {
        $result = $this->model->findOrFail($id);
        $result->update($attributes);
    }

    function delete($id)
    {
        $result = $this->model->findOrFail($id);
        $result->delete();
    }

    function page($amount, $filter = null)
    {
        if (isset($filter)) {
            return $this->model->ofType($filter)->paginate($amount);
        } else {
            return $this->model->latest()->paginate($amount);
        }
    }
}
