<?php

namespace App\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    function create($attributes)
    {
        if ($attributes['supplier'] == 'add') {
            $supplier = Supplier::create([
                'name' => $attributes['new_supplier'],
                'description' => 'Danh mục ' . $attributes['new_supplier']
            ]);
            $attributes['supplier'] = $supplier->id;
        }

        if ($attributes['category'] == 'add') {
            $category = Category::create([
                'name' => $attributes['new_category'],
                'description' => 'Danh mục ' . $attributes['new_category']
            ]);
            $attributes['category'] = $category->id;
        }


        $product = parent::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'supplier_id' => $attributes['supplier'],
            'price' => $attributes['price'],
            'status' => $attributes['status'],
            'sku' => $attributes['sku'],
            'quantity' => $attributes['quantity'],
            'category_id' => $attributes['category'],
        ]);

        if (!empty($attributes['images'])) {
            $product->images()->createMany($attributes['images']);
        }
    }

    public function update($id, $attributes)
    {
        $product = $this->model->findOrFail($id);

        if ($attributes['supplier'] == 'add') {
            $supplier = Supplier::create([
                'name' => $attributes['new_supplier'],
                'description' => 'Danh mục ' . $attributes['new_supplier']
            ]);
            $attributes['supplier'] = $supplier->id;
        }

        if ($attributes['category'] == 'add') {
            $category = Category::create([
                'name' => $attributes['new_category'],
                'description' => 'Danh mục ' . $attributes['new_category']
            ]);
            $attributes['category'] = $category->id;
        }

        $product->update(
            [
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'supplier_id' => $attributes['supplier'],
                'price' => $attributes['price'],
                'status' => $attributes['status'],
                'sku' => $attributes['sku'],
                'quantity' => $attributes['quantity'],
                'category_id' => $attributes['category'],
            ]
        );

        if (!empty($attributes['images'])) {
            $product->images()->delete();
            $product->images()->createMany($attributes['images']);
        }
    }

    public function getImages($id)
    {
        return $this->find($id)->images;
    }

    public function findByIdOrSku($id_sku)
    {
        return $this->model->where('id' ,'=' , $id_sku)->orWhere('sku', '=', $id_sku)->first();
    }
}
