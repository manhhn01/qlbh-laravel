<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierCreateRequest;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
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
        if ($request->has(['search'])) {
            $filter['name'] = $request->search;
        }
        $suppliers = $this->supplierRepo->page(5, $filter ?? null);

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
        if ($request->hasAny(['search', 'status'])) {
            $filter['name'] = $request->search;
            $filter['status'] = $request->status;
        }

        try {
            $supplier = $this->supplierRepo->find($id);
            $products = $this->supplierRepo->getProductspage(5, $id, $filter ?? null);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy nhà cung cấp']);
        }

        return view('admin.supplier.show', [
            'id' => $id,
            'supplier' => $supplier,
            'products' => $products,
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

        try {
            $this->supplierRepo->update($id, $attributes);
        } catch (ModelNotFoundException $e) {
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

    public function ajax(Request $request)
    {
        $id_name = $request->id_name;
        try {
            $supplier = $this->supplierRepo->findByIdOrName($id_name);
            if (empty($supplier)) {
                throw new ModelNotFoundException();
            } else {
                return response()->json([
                    'data' => [
                        'supplier_id' => $supplier->id,
                        'supplier_name' => $supplier->name,
                        'description' => $supplier->description,
                    ],
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => [
                    'code' => $e->getCode(),
                    'message' => 'Lỗi truy vấn cơ sở dữ liệu',
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Không tìm thấy nhà cung cấp',
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'code' => $e->getCode(),
                    'message' => 'Lỗi hệ thống',
                ],
            ]);
        }
    }
}
