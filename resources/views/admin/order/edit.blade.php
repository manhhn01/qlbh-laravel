@extends('layouts.admin.app')
@section('content-main')
<form action="{{ route('order.update', ['id' => $id, 'page' => request()->page]) }}" method="POST">
    @csrf()
    <div class="content-header">
        <h2 class="content-title">Cập nhật đơn hàng #{{ $order->id }}</h2>
        <div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Địa điểm mua hàng</label>
                        <select class="form-select" id="buy_place" name="buy_place">
                            <option value="" disabled selected>Chọn địa điểm</option>
                            <option value="0" {{ $order->buy_place === 0 ? 'selected' : ''}}>Online
                            </option>
                            <option value="1" {{ $order->buy_place === 1 ? 'selected' : ''}}>Tại cửa hàng
                            </option>
                        </select>
                    </div>

                    <div class="order-info-container"></div>
                    <template id="onTemplate">
                        <div class="mb-4">
                            <label for="customer_email" class="form-label">Email khách hàng</label>
                            <input type="text" name="customer_email" id="customer_email" class="form-control"
                                   placeholder="Nhập ở đây" value="{{$order->customer_email}}">
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Phương thức thanh toán</label>
                                <select class="form-select" name="payment_method">
                                    <option value="0" {{$order->status === 0 ? 'selected' : ''}}>Chuyển khoản ngân
                                        hàng
                                    </option>
                                    <option value="1" {{$order->status === 1 ? 'selected' : ''}}>Thanh toán khi
                                        nhận hàng
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Trạng thái đơn hàng</label>
                                <select class="form-select" name="status">
                                    <option value="0" {{$order->status === 0 ? 'selected' : ''}}>Đang chuẩn bị
                                    </option>
                                    <option value="1" {{$order->status === 1 ? 'selected' : ''}}>Đang giao</option>
                                    <option value="2" {{$order->status === 2 ? 'selected' : ''}}>Đã giao</option>
                                    <option value="3" {{$order->status === 3 ? 'selected' : ''}}>Đã hủy</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="deliver_to" class="form-label">Địa chỉ giao hàng</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control" name="deliver_to"
                                   id="deliver_to" value="{{ $order->deliver_to }}">
                        </div>
                        <x-order-products :products="$order->products"/>
                        <div class="mb-4">
                            <label for="coupon_name" class="form-label">Mã giảm giá</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control coupon-input no-check"
                                   id="coupon_name" data-valid="true" value="{{ $order->coupon_id ?? "" }}">
                            <div class="coupon-card-container mt-2"></div>
                            <div id="couponLoad" class="d-none">
                                <div class="d-flexjustify-content-center">
                                    <div class="lds-ring">
                                        <div></div><div></div><div></div><div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea type="text" placeholder="Nhập ở đây..." class="form-control" name="note"
                                      id="note">{{ $order->note }}</textarea>
                        </div>
                    </template>
                    {{--                        --}}
                    <template id="offTemplate">
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Phương thức thanh toán</label>
                                <select class="form-select" name="payment_method">
                                    <option value="0" {{$order->status === 0 ? 'selected' : ''}}>Chuyển khoản ngân
                                        hàng
                                    </option>
                                    <option value="1" {{$order->status === 2 ? 'selected' : ''}}>Thanh toán tiền
                                        mặt
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Trạng thái đơn hàng</label>
                                <select class="form-select" name="status">
                                    <option value="0" {{$order->status === 0 ? 'selected' : ''}}>Đang chuẩn bị</option>
                                    <option value="1" {{$order->status === 1 ? 'selected' : ''}}>Đang giao</option>
                                    <option value="2" {{$order->status === 2 ? 'selected' : ''}}>Đã giao</option>
                                    <option value="3" {{$order->status === 3 ? 'selected' : ''}}>Đã hủy</option>
                                </select>
                            </div>
                        </div>
                        <x-order-products :products="$order->products"/>
                        <div class="mb-4">
                            <label for="coupon_name" class="form-label">Mã giảm giá</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control coupon-input no-check"
                                   id="coupon_name" data-valid="true" value="{{ $order->coupon_id ?? "" }}">
                            <div class="coupon-card-container mt-2"></div>
                            <div id="couponLoad" class="d-none">
                                <div class="d-flexjustify-content-center">
                                    <div class="lds-ring">
                                        <div></div><div></div><div></div><div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea type="text" placeholder="Nhập ở đây..." class="form-control" name="note"
                                      id="note">{{ $order->note }}</textarea>
                        </div>
                    </template>
                </div>
            </div> <!-- card end// -->
        </div> <!-- card end// -->
    </div> <!-- row end// -->
</form>

@endsection

@push('js')
    <script src="{{ asset('js/order/script.js') }}"></script>
@endpush
