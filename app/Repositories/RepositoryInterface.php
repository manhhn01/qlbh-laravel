<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RepositoryInterface
{
    /**
     * Get all order by created_at
     * @return mixed
     */
    function getAll();

    /**
     * find by id
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    function find($id);

    /**
     * create
     * @param $attributes
     * @return mixed
     */
    function create($attributes);

    /**
     * update with id
     * @param $id
     * @param $attributes
     * @return mixed
     * @throws ModelNotFoundException
     */
    function update($id, $attributes);

    /**
     * delete by id
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    function delete($id);

    /**
     * Return paginate with filter
     * @param $amount
     * @param null $filter
     * @return mixed
     */
    function page($amount, $filter);
}
