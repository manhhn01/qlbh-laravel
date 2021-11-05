@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Danh sách đơn hàng</h2>
        <div>
            <a href="{{ route('order.create',  ['page'=>request()->page, 'search'=>request()->search]) }}" type="submit"
               class="btn btn-primary">Thêm đơn hàng</a>
        </div>
    </div>
    <section class="content-main">
        <div class="card mb-4">
            <header class="card-header">
                <div class="row gx-3">
                    <div class="col-lg-8 col-md-8 me-auto col-8">
                        <input type="text" placeholder="Search..." class="form-control">
                    </div>
                    <div class="col-lg-4 col-4 col-md-4">
                        <select class="form-select">
                            <option>Status</option>
                            <option>Active</option>
                            <option>Disabled</option>
                            <option>Show all</option>
                        </select>
                    </div>
                </div>
            </header>

            <div class="card-body">
                @if ($orders->isEmpty())
                    <div>Không có đơn hàng nào</div>
                @endif
                @foreach ($orders as $order)
                    <article class="itemlist">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-8  flex-grow-1 col-name">
                                <a class="itemside"
                                   href="{{ route('order.show', ['id'=>$order->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                                    <div class="left">
                                        <span class="order-id">{{ $order->id }}</span>
                                    </div>
                                    <div class="info">
                                        <h6 class="mb-0">{{ $order->customer->full_name }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-4 col-price">
                                <span>100.000 D</span>
                            </div>
                            <div class="col-md-2 col-4 col-status">
                                @switch($order->status)
                                    @case(0)
                                    <span
                                        class="badge rounded-pill alert-secondary">Đang chuẩn bị</span>
                                    @break
                                    @case(1)
                                    <span
                                        class="badge rounded-pill alert-primary">Đang giao</span>
                                    @break
                                    @case(2)
                                    <span
                                        class="badge rounded-pill alert-success">Đã giao</span>
                                    @break
                                    @default
                                    <span
                                        class="badge rounded-pill alert-danger">Đã hủy</span>
                                @endswitch
                            </div>
                            <div class="col-md-3 col-4 col-date">
                                <span>{{ $order->created_at }}</span>
                            </div>
                            <div class="col-md-1 col-4 col-action">
                                <div class="dropdown float-end">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i
                                            class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ route('order.show', ['id'=>$order->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Xem
                                            chi tiết</a>
                                        <a class="dropdown-item"
                                           href="{{ route('order.edit', ['id'=>$order->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Sửa</a>
                                        <form class="delete-order" data-id="{{ $order->id }}"
                                              data-name={{ $order->customer->name }} action="{{ route('order.destroy', ['id'=>$order->id]) }}"
                                              method="POST">
                                            @csrf
                                            <button class="dropdown-item text-danger" style="outline:none">Xóa</button>
                                        </form>
                                    </div>
                                </div> <!-- dropdown // -->
                            </div>
                        </div> <!-- row .// -->
                    </article> <!-- itemlist  .// -->
                @endforeach

                <nav class="float-end mt-4" aria-label="Page navigation">
                    <nav class="float-end mt-4" aria-label="Page navigation">
                        {!! $orders->links() !!}
                    </nav>
                </nav>

            </div> <!-- card-body end// -->
        </div> <!-- card end// -->

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/order/script.js') }}"></script>
@endpush
