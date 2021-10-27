<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index()
    {
        $search_param = request()->search;
        $data = [];
        if (!empty($search_param)) {
            $product = Product::where('name', 'like', '%' . $search_param . '%')->orderBy('name');
            $data['products'] = $product->paginate(10);
        } else {
            $data['products'] = Product::paginate(10);
        }

        return view(
            'admin.product.index',
            $data
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

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
        $data = $request->only(['name', 'description', 'supplier', 'new_supplier', 'price', 'status', 'category', 'new_category', 'quantity']);
        if ($data['supplier'] == 'add') {
            $supplier = Supplier::create([
                'name' => $data['new_supplier'],
                'description' => 'Danh mục ' . $data['new_supplier']
            ]);
            $data['supplier'] = $supplier->id;
        }

        if ($data['category'] == 'add') {
            $category = Category::create([
                'name' => $data['new_category'],
                'description' => 'Danh mục ' . $data['new_category']
            ]);
            $data['category'] = $category->id;
        }
        //todo validate file max size
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('images/product', $name);
                $data['images'][] = ['image_path' => $name];
            }
        }

        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'supplier_id' => $data['supplier'],
            'price' => $data['price'],
            'status' => $data['status'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category'],
        ]);

        if (!empty($data['images'])) {
            $product->images()->createMany($data['images']);
        } else {
            $product->images()->create([
                'image_path' => ''
            ]);
        }
        return back()->with('info', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View | RedirectResponse
     */
    public function show($id)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        try {
            $product = Product::findOrFail($id);
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
    public function edit($id)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        try {
            $product = Product::findOrFail($id);
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
    public function update(ProductCreateRequest $request, $id)
    {
        $data = $request->only(['name', 'description', 'supplier', 'new_supplier', 'price', 'status', 'category', 'new_category', 'quantity']);

        if ($data['supplier'] == 'add') {
            $supplier = Supplier::create([
                'name' => $data['new_supplier'],
                'description' => 'Danh mục ' . $data['new_supplier']
            ]);
            $data['supplier'] = $supplier->id;
        }

        if ($data['category'] == 'add') {
            $category = Category::create([
                'name' => $data['new_category'],
                'description' => 'Danh mục ' . $data['new_category']
            ]);
            $data['category'] = $category->id;
        }

        $product = Product::updateOrCreate(
            ['id' => $id],
            [
                'name' => $data['name'],
                'description' => $data['description'],
                'supplier_id' => $data['supplier'],
                'price' => $data['price'],
                'status' => $data['status'],
                'quantity' => $data['quantity'],
                'category_id' => $data['category'],
            ]
        );

        //todo validate file max size
        if ($request->hasFile('images')) { //neu nhu co anh upload => thay the anh cu = anh moi
            Storage::delete($product->images->map(function ($item) {
                return 'images/product/' . $item->image_path;
            })->toArray()); // xoa  anh trong storage
            $product->images()->delete();
            foreach ($request->file('images') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('images/product', $name);
                $data['images'][] = ['image_path' => $name];
            }
            $product->images()->createMany($data['images']);
        }

        return redirect(route('product.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            Product::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy sản phẩm để xóa']);
        }
        return back()->with('info', 'Xóa sản phẩm thành công');
    }
}
