<?php

namespace App\Repositories\Order;

use App\Exceptions\InvalidQuantityException;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    function create($attributes)
    {
        $order_prods = $attributes["products"];
        if (isset($attributes["coupon_id"]))
            try {
                Coupon::findOrFail($attributes["coupon_id"]);
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Không tìm thấy mã giảm giá");
            }

        $temp_products = [];
        foreach ($order_prods as $order_prod) {
            try {
                $product = Product::findOrFail($order_prod["product_id"]);

                if ($order_prod["quantity"] > $product->quantity)
                    throw new InvalidQuantityException("Số lượng sản phẩm lớn hơn số lượng có");

                $temp_products[$order_prod["product_id"]] = ['quantity' => $order_prod["quantity"], 'price' => $product->price];
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Không tìm thấy sản phẩm");
            }
        }

        $order = Order::create($attributes);
        $order->orderProducts()->attach($temp_products);
    }

}
