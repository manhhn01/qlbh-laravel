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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
