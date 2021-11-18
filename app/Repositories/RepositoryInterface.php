<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RepositoryInterface
{
    /**
     * Get all order by created_at.
     * @return mixed
     */
    public function getAll();

    /**
     * find by id.
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function find($id);

    /**
     * create.
     * @param $attributes
     * @return mixed
     */
    public function create($attributes);

    /**
     * update with id.
     * @param $id
     * @param $attributes
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function update($id, $attributes);

    /**
     * delete by id.
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function delete($id);

    /**
     * Return paginate with filter.
     * @param $amount
     * @param null $filter
     * @return mixed
     */
    public function page($amount, $filter);
}
