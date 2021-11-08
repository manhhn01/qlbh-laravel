<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponCreateRequest;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponRepo;

    public function __construct(CouponRepositoryInterface $couponRepo)
    {
        $this->middleware(['auth', 'admin']);

        $this->couponRepo = $couponRepo;
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
        $coupons = $this->couponRepo->page(2, $filter ?? null);
        return view(
            'admin.coupon.index',
            ['coupons' => $coupons]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponCreateRequest $request
     * @return RedirectResponse
     */
    public function store(CouponCreateRequest $request)
    {
        $attributes = $request->only(['name', 'discount', 'remain', 'expired_at', 'description']);

        $this->couponRepo->create($attributes);

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
        try {
            $coupon = $this->couponRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy mã giảm giá']);
        }
        return view('admin.coupon.show', [
            'id' => $id,
            'coupon' => $coupon
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
        try {
            $coupon = $this->couponRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy mã giảm giá']);
        }
        return view('admin.coupon.edit', [
            'id' => $id,
            'coupon' => $coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CouponCreateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CouponCreateRequest $request, int $id)
    {
        $attributes = $request->only(['name', 'discount', 'remain', 'expired_at', 'description']);

        try{
            $this->couponRepo->update($id, $attributes);

        } catch (ModelNotFoundException $e){
            return back()->withErrors(['message' => 'Không tìm thấy mã giảm giá']);
        }
        return redirect(route('coupon.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
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
            $this->couponRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy mã giảm giá để xóa']);
        }
        return back()->with('info', 'Xóa mã giảm giá thành công');
    }

    /**
     * Xử lý ajax lấy mã giảm
     *
     * @param Request $request
     * @return JsonResponse
     */

    function ajax(Request $request)
    {
        $id_name = $request->id_name;
        try {
            $coupon = $this->couponRepo->findByIdOrName($id_name);
            if (!isset($coupon)) {
                throw new ModelNotFoundException;
            } else
                return response()->json([
                    "data" => [
                        "coupon_id" => $coupon->id,
                        "coupon_name" => $coupon->name,
                        "discount" => $coupon->discount,
                        "remain" => $coupon->remain,
                        "description" => $coupon->description,
                        "expired_at" => $coupon->expired_at,
                    ]
                ]);
        } catch (QueryException $e) {
            return response()->json([
                "error" => [
                    "code" => $e->getCode(),
                    "message" => "Lỗi truy vấn cơ sở dữ liệu",
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "error" => [
                    "code" => 404,
                    "message" => "Không tìm thấy mã giảm giá",
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => [
                    "code" => $e->getCode(),
                    "message" => "Lỗi hệ thống",
                ]
            ]);
        }
    }
}
