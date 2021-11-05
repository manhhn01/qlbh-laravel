<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierCreateRequest;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    protected $supplierRepo;

    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->middleware(['auth', 'admin']);

        $this->supplierRepo = $supplierRepo;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if ($request->has(["search"])) {
            $filter["name"] = $request->search;
        }
        $suppliers= $this->supplierRepo->page(2, $filter ?? null);
        return view(
            'admin.supplier.index',
            ['suppliers' => $suppliers]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SupplierCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(SupplierCreateRequest $request)
    {
        $attributes = $request->only(['name', 'description']);

        $this->supplierRepo->create($attributes);

        return back()->with('info', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return View | RedirectResponse
     */
    public function show(int $id, Request $request)
    {
        //filter products
        if ($request->hasAny(["search", "status"])) {
            $filter["name"] = $request->search;
            $filter["status"] = $request->status;
        }

        try {
            $supplier = $this->supplierRepo->find($id);
            $products = $this->supplierRepo->getProductsPage(2, $id, $filter ?? null);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy nhà cung cấp']);
        }
        return view('admin.supplier.show', [
            'id' => $id,
            'supplier' => $supplier,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse | View
     */
    public function edit(int $id)
    {
        try {
            $supplier = $this->supplierRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy nhà cung cấp']);
        }
        return view('admin.supplier.edit', [
            'id' => $id,
            'supplier' => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SupplierCreateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SupplierCreateRequest $request, int $id)
    {
        $attributes = $request->only(['name', 'description']);

        try{
            $this->supplierRepo->update($id, [
                'name' => $attributes['name'],
                'description' => $attributes['description']
            ]);

        } catch (ModelNotFoundException $e){
            return back()->withErrors(['message' => 'Không tìm thấy nhà cung cấp']);
        }
        return redirect(route('supplier.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->supplierRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy nhà cung cấp để xóa']);
        }
        return back()->with('info', 'Xóa nhà cung cấp thành công');
    }
}
