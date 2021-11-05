<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->middleware(['auth']); // Nhân viên và người quản lý có thể truy cập vào tính năng này

        $this->orderRepo = $orderRepo;
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
        $orders = $this->orderRepo->page(2, $filter ?? null);
        return view(
            'admin.order.index',
            ['orders' => $orders]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderCreateRequest $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $buy_place = $request->buy_place;
        if ($buy_place === "online") {
            $attributes = $request->only(['customer_email','payment_method', 'status', 'deliver_to', 'product', 'coupon_id', 'note']);
        } else if ($buy_place == "offline") {
            $attributes = $request->only(['payment_method', 'status', 'product']);
        } else return back()->withErrors("messages", "Vui lòng chọn nơi mua");

        $this->orderRepo->create($attributes);

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
        $filter["name"] = $request->search;
        $filter["status"] = $request->status;

        try {
            $order = $this->orderRepo->find($id);
            $products = $this->orderRepo->getProductsPage(2, $id, $filter);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy đơn hàng']);
        }
        return view('admin.order.show', [
            'id' => $id,
            'order' => $order,
            'products' => $products
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
        try {
            $order = $this->orderRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy đơn hàng']);
        }
        return view('admin.order.edit', [
            'id' => $id,
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderCreateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(OrderCreateRequest $request, int $id)
    {
        $attributes = $request->only(['name', 'description']);

        try {

            $this->orderRepo->update($id, [
                'name' => $attributes['name'],
                'description' => $attributes['description']
            ]);

        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy đơn hàng']);
        }
        return redirect(route('order.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
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
            $this->orderRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy đơn hàng để xóa']);
        }
        return back()->with('info', 'Xóa đơn hàng thành công');
    }
}
