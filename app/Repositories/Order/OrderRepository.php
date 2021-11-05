<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    function getProductsPage($amount, $order_id, $filter = null)
    {
        return Product::where('order_id', $order_id)->ofType($filter)->paginate($amount);
    }
}
