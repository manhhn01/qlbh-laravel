<?php

namespace App\Repositories\Order;

use App\Exceptions\ExpiredCouponException;
use App\Exceptions\InvalidQuantityException;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * create order with products.
     * @param $attributes
     * @throws ModelNotFoundException | InvalidQuantityException | ExpiredCouponException
     * @return mixed
     */
    public function create($attributes);

    /**
     * @param $id
     * @param $attributes
     * @throws ModelNotFoundException | InvalidQuantityException
     * @return mixed
     */
    public function update($id, $attributes);

    /**
     * get latest order
     */
    public function latest($limit);
    public function updateStatistic($order);
}
