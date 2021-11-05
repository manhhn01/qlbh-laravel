<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

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
}
