<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        return $this->model->all();
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

    function page($amount, $search_keyword = null)
    {
        if (isset($search_keyword)) {
            return $this->model->where('name', 'like', "%$search_keyword%")->orderBy('name')->paginate($amount);
        } else {
            return $this->model->latest()->paginate($amount);
        }
    }
}
