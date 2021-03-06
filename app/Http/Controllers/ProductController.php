<?php

namespace App\Http\Controllers;

use App\Exceptions\TableConstraintException;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $supplierRepo;

    public function __construct(
        ProductRepositoryInterface $product,
        CategoryRepositoryInterface $category,
        SupplierRepositoryInterface $supplier
    ) {
        $this->middleware(['auth']);
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
        if ($request->hasAny(['search', 'status'])) {
            $filter['name'] = $request->search;
            $filter['status'] = $request->status;
        }
        $products = $this->productRepo->page(5, $filter ?? null);

        return view(
            'admin.product.index',
            ['products' => $products]
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
                'suppliers' => $suppliers,
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
        $attributes = $request->only(['name', 'description', 'supplier', 'new_supplier', 'price', 'status', 'sku', 'category', 'new_category', 'quantity']);
        //upload file len storage
        //todo validate file max size
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('images/product', $name);
                $attributes['images'][] = ['image_path' => $name];
            }
        }

        // dd($attributes);
        $this->productRepo->create($attributes);

        return back()->with('info', 'T???o th??nh c??ng');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View | RedirectResponse
     */
    public function show(int $id)
    {
        try {
            $product = $this->productRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Kh??ng t??m th???y s???n ph???m']);
        }

        return view('admin.product.show', [
            'id' => $id,
            'product' => $product,
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
            return back()->withErrors(['message' => 'Kh??ng t??m th???y s???n ph???m']);
        }

        return view('admin.product.edit', [
            'id' => $id,
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCreateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, int $id)
    {
        $attributes = $request->only(['name', 'description', 'supplier', 'new_supplier', 'price', 'status', 'sku', 'category', 'new_category', 'quantity']);

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
            return back()->withErrors(['message' => 'Kh??ng t??m th???y s???n ph???m']);
        }

        return redirect(route('product.list', ['page' => request()->page]))->with('info', 'C???p nh???t th??nh c??ng');
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
            return back()->withErrors(['message' => 'Kh??ng t??m th???y s???n ph???m']);
        } catch (TableConstraintException $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        return back()->with('info', 'X??a s???n ph???m th??nh c??ng');
    }

    /**
     * X??? l?? ajax l???y s???n ph???m.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        $id_sku = $request->id_sku;
        try {
            $product = $this->productRepo->findByIdOrSku($id_sku);
            if (empty($product)) {
                throw new ModelNotFoundException();
            } else {
                return response()->json([
                    'data' => [
                        'product_name' => $product->name,
                        'product_id' => $product->id,
                        'sku' => $product->sku,
                        'price' => $product->price,
                        'quantity' => $product->quantity,
                        'status' => $product->status,
                        'image_path' => $product->images->first(),
                    ],
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => [
                    'code' => $e->getCode(),
                    'message' => 'L???i truy v???n c?? s??? d??? li???u',
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Kh??ng t??m th???y s???n ph???m',
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'code' => $e->getCode(),
                    'message' => 'L???i h??? th???ng',
                ],
            ]);
        }
    }
}
