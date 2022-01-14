<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponCreateRequest;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    protected $couponRepo;

    public function __construct(CouponRepositoryInterface $couponRepo)
    {
        $this->middleware(['auth']);

        $this->couponRepo = $couponRepo;
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
        $coupons = $this->couponRepo->page(5, $filter ?? null);

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
        $attributes = $request->only(['name', 'discount', 'remain', 'expire_at', 'description']);

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
            'coupon' => $coupon,
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
            'coupon' => $coupon,
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
        $attributes = $request->only(['name', 'discount', 'remain', 'expire_at', 'description']);

        try {
            $this->couponRepo->update($id, $attributes);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy mã giảm giá']);
        }

        return redirect(route('coupon.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
//
    }

    /**
     * Xử lý ajax lấy mã giảm.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        $id_name = $request->id_name;
        $check = json_decode($request->check);
        try {
            $coupon = $this->couponRepo->findByIdOrName($id_name);
            if (empty($coupon) || (!$coupon->isUsable && $check)) {
                throw new ModelNotFoundException();
            } else {
                return response()->json([
                    'data' => [
                        'coupon_id' => $coupon->id,
                        'coupon_name' => $coupon->name,
                        'discount' => $coupon->discount,
                        'remain' => $coupon->remain,
                        'description' => $coupon->description,
                        'expire_at' => $coupon->expire_at,
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
                    'message' => 'Không tìm thấy mã giảm giá hoặc mã đã hết hạn',
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
