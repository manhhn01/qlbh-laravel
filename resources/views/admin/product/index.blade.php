@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Danh sách sản phẩm</h2>
        <div>
            <a href="{{ route('product.create',  ['page'=>request()->page, 'search'=>request()->search]) }}"
               type="submit" class="btn btn-primary">Thêm sản phẩm</a>
        </div>
    </div>

    <section class="content-main">
        <div class="card mb-4">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-4 col-6 ms-auto">
                        <form action="{{ route('product.list') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Tìm sản phẩm"
                                       value="{{ request()->search }}">
                                <button class="btn btn-light bg" type="submit">
                                    <i class="material-icons md-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 col-6">
                        <form class="status-form" action="{{route('product.list')}}" method="get">
                            <select class="form-select status-select" name="status">
                                <option value="">Tất cả</option>
                                <option value="1">Đang bán</option>
                                <option value="0" {{ request()->query('status')==0 ? 'selected' : '' }}>Dừng bán
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
            </header> <!-- card-header end// -->

            <div class="card-body">
                @if ($products->isEmpty())
                    <div>Không có sản phẩm nào</div>
                @endif

                @foreach ($products as $product)
                    <article class="itemlist">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                                <a class="itemside"
                                   href="{{ route('product.show', ['id'=>$product->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                                    <div class="left">
                                        @if ($product->images->first()->image_path == '')
                                            <img src="{{ asset('images/logo.png') }}" class="img-sm img-thumbnail"
                                                 alt="Item">
                                        @else
                                            <img
                                                src="{{ asset('images/product/'.$product->images->first()->image_path) }}"
                                                class="img-sm img-thumbnail" alt="Item">
                                        @endif
                                    </div>
                                    <div class="info">
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-4 col-price"><span>{{ number_format($product->price, 0, ",", ".") }} đ</span>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-4 col-status">
                                <span
                                    class="badge rounded-pill {{ $product->status==1 ? 'alert-success' :  'alert-warning'}}">{{ $product->status==1 ? 'Đang bán' :  'Dừng bán'}}</span>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-4 col-date">
                                <span>{{ $product->created_at }}</span>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-4 col-action">
                                <div class="dropdown float-end">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i
                                            class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('product.show', ['id'=>$product->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Xem chi tiết</a>
                                        <a class="dropdown-item" href="{{ route('product.edit', ['id'=>$product->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Sửa</a>
                                        <form class="delete-product" data-id="{{ $product->id }}"
                                              data-name={{ $product->name }} action="{{ route('product.destroy', ['id'=>$product->id]) }}"
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
                    {!! $products->links() !!}
                </nav>

            </div> <!-- card-body end// -->
        </div> <!-- card end// -->

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/product/script.js') }}"></script>
@endpush
