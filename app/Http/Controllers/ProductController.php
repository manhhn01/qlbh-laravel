<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $supplierRepo;

    public function __construct(ProductRepositoryInterface  $product,
                                CategoryRepositoryInterface $category,
                                SupplierRepositoryInterface $supplier)
    {
        $this->middleware(['auth', 'admin']);
        $this->productRepo = $product;
        $this->categoryRepo = $category;
        $this->supplierRepo = $supplier;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(Request $request)
    {
        $filter["name"] = $request->search;
        $filter["status"] = $request->status;
        $products = $this->productRepo->page(10, $filter);
        return view(
            'admin.product.index',
            ["products" => $products]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $categories = $this->categoryRepo->getAll();
        $suppliers = $this->supplierRepo->getAll();

        return view(
            'admin.product.create',
            [
                'categories' => $categories,
                'suppliers' => $suppliers
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(ProductCreateRequest $request)
    {
        $attributes = $request->only(['name', 'description', 'supplier', 'new_supplier', 'price', 'status', 'category', 'new_category', 'quantity']);

        //upload file len storage
        //todo validate file max size
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('images/product', $name);
                $attributes['images'][] = ['image_path' => $name];
            }
        }
        $this->productRepo->create($attributes);
        return back()->with('info', 'Tạo thành công');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View | RedirectResponse
     */
    public function show(int $id)
    {
        $categories = $this->categoryRepo->getAll();
        $suppliers = $this->supplierRepo->getAll();

        try {
            $product = $this->productRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy sản phẩm']);
        }

        return view('admin.product.show', [
            'id' => $id,
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View | RedirectResponse
     */
    public function edit(int $id)
    {
        $categories = $this->categoryRepo->getAll();
        $suppliers = $this->supplierRepo->getAll();

        try {
            $product = $this->productRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy sản phẩm']);
        }

        return view('admin.product.edit', [
            'id' => $id,
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCreateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ProductCreateRequest $request, int $id)
    {
        $attributes = $request->only(['name', 'description', 'supplier', 'new_supplier', 'price', 'status', 'category', 'new_category', 'quantity']);

        //todo validate file max size
        if ($request->hasFile('images')) { //neu nhu co anh upload => thay the anh cu = anh moi
            Storage::delete(    // xoa  anh cu trong storage
                $this->productRepo
                    ->getImages($id)
                    ->map(function ($item) {
                        return 'images/product/' . $item->image_path;
                    })
                    ->toArray()
            );

            foreach ($request->file('images') as $file) { //luu file moi
                $name = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('images/product', $name);
                $attributes['images'][] = ['image_path' => $name];
            }
        }

        try {
            $this->productRepo->update($id, $attributes);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy sản phẩm']);
        }

        return redirect(route('product.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->productRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy sản phẩm']);
        }

        return back()->with('info', 'Xóa sản phẩm thành công');
    }
}
