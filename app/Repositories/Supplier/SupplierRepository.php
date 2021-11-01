<?php

namespace App\Repositories\Supplier;

use App\Models\Product;
use App\Models\Supplier;
use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function getModel()
    {
        return Supplier::class;
    }

    function getProductsPage($amount, $supplier_id, $filter = null)
    {
        if(isset($filter))
        return Product::where('supplier_id', $supplier_id)->ofType($filter)->paginate($amount);
        else{
            return Product::orderByDesc('created_at')->paginate($amount);
        }
    }
}
