<?php

namespace App\Repositories\Order;

use App\Exceptions\ExpiredCouponException;
use App\Exceptions\InvalidQuantityException;
use App\Repositories\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * return products paginate
     * @param $amount
     * @param $order_id
     * @param null $filter
     * @return mixed
     */
    function getProductsPage($amount, $order_id, $filter);

    /**
     * create order with products
     * @param $attributes
     * @throws ModelNotFoundException | InvalidQuantityException | ExpiredCouponException
     * @return mixed
     */
    function create($attributes);

    /**
     * @param $id
     * @param $attributes
     * @throws ModelNotFoundException
     * @return mixed
     */
    function update($id, $attributes);
}
