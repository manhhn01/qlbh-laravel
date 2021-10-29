<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $categoryRepo;
    protected $supplierRepo;

    function __construct(CategoryRepositoryInterface $categoryRepo,
                         SupplierRepositoryInterface $supplierRepo)
    {
        Parent::__construct();
        $this->categoryRepo = $categoryRepo;
        $this->supplierRepo = $supplierRepo;
    }

    public function getModel()
    {
        return Product::class;
    }

    function create($attributes)
    {
        if ($attributes['supplier'] == 'add') {
            $supplier = $this->supplierRepo->create([
                'name' => $attributes['new_supplier'],
                'description' => 'Danh mục ' . $attributes['new_supplier']
            ]);
            $attributes['supplier'] = $supplier->id;
        }

        if ($attributes['category'] == 'add') {
            $category = $this->categoryRepo->create([
                'name' => $attributes['new_category'],
                'description' => 'Danh mục ' . $attributes['new_category']
            ]);
            $attributes['category'] = $category->id;
        }


        parent::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'supplier_id' => $attributes['supplier'],
            'price' => $attributes['price'],
            'status' => $attributes['status'],
            'quantity' => $attributes['quantity'],
            'category_id' => $attributes['category'],
        ])->images()->createMany($attributes['images']);
    }

    public function update($id, $attributes)
    {
        $product = $this->model->findOrFail($id);

        if ($attributes['supplier'] == 'add') {
            $supplier = $this->supplierRepo->create([
                'name' => $attributes['new_supplier'],
                'description' => 'Danh mục ' . $attributes['new_supplier']
            ]);
            $attributes['supplier'] = $supplier->id;
        }

        if ($attributes['category'] == 'add') {
            $category = $this->categoryRepo->create([
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
                'quantity' => $attributes['quantity'],
                'category_id' => $attributes['category'],
            ]
        );

        if (isset($attributes['images'])) {
            $product->images()->delete();
            $product->images()->createMany($attributes['images']);
        }
    }

    public function getImages($id){
        return $this->find($id)->images;
    }
}
