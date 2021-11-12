<?php

namespace App\Repositories\Order;

use App\Exceptions\ExpiredCouponException;
use App\Exceptions\InvalidQuantityException;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

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
        if (!empty($attributes["coupon_id"])) {
            try {
                $coupon = Coupon::findOrFail($attributes["coupon_id"]);
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Không tìm thấy mã giảm giá");
            }
            if (!$coupon->isUsable) {
                throw new ExpiredCouponException("Mã giảm giá đã hết hạn");
            }
        }

        $attach_products = [];
        foreach ($order_prods as $order_prod) {
            try {
                $product = Product::findOrFail($order_prod["product_id"]);

                if ($order_prod["quantity"] > $product->quantity)
                    throw new InvalidQuantityException("Số lượng sản phẩm lớn hơn số lượng có");

                $attach_products[$order_prod["product_id"]] = [
                    'quantity' => $order_prod["quantity"],
                    'price' => $product->price
                ];
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Không tìm thấy sản phẩm");
            }
        }


        $order = parent::create($attributes);

        $order->products()->attach($attach_products);
        // cach 2
        // foreach ($order_prods as $order_prod) {
        //     $order->products()->attach( $order_prod["product_id"], ['quantity' => $order_prod["quantity"], 'price' => $order_prod["price"]]);
        // }

        if (!empty($order->coupon))
            $order->coupon->decrement('remain');
        foreach ($order->products as $product) {
            $product->decrement('quantity', $product->pivot->quantity);
        }
    }

    public function update($id, $attributes)
    {
        try {
            $order = $this->model->find($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Không tìm thấy đơn hàng");
        }

        $order_prods = $attributes["products"];
        if (!empty($attributes["coupon_id"])) {
            try {
                $coupon = Coupon::findOrFail($attributes["coupon_id"]);
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Không tìm thấy mã giảm giá");
            }
        }

        $sync_products = [];
        foreach ($order_prods as $new_product) {
            try {
                $product = Product::findOrFail($new_product["product_id"]); //trong kho
                $old_product = $order->products->where("id", $new_product["product_id"])->first(); //trong don hang
                if(!empty($old_product)){
                    //todo
                }
                if ($product->quantity + $old_product->pivot->quantity  - $new_product["quantity"] < 0)
                    throw new InvalidQuantityException("Số lượng sản phẩm lớn hơn số lượng có");

                $sync_products[$new_product["product_id"]] = [
                    'quantity' => $new_product["quantity"],
                    'price' => $product->price
                ];
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Không tìm thấy sản phẩm");
            }
        }

        // tra lai hang cu ve kho
        foreach ($order->products as $product) {
            $product->increment('quantity', $product->pivot->quantity);
        }
        if (!empty($order->coupon))
            $order->coupon->increment('remain');

        $order = parent::update($id, $attributes);
        // thay cho attach
        $order->products()->sync($sync_products);

        //cap nhat lai hang trong kho
        foreach ($order->products as $product) {
            $product->decrement('quantity', $product->pivot->quantity);
        }
        if (!empty($order->coupon))
            $order->coupon->decrement('remain');
    }

}
