@extends('layouts.admin.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Thông tin sản phẩm</h2>
    <div>
            <a href="{{ route('product.edit',  ['id'=>$id, 'page'=>request()->page, 'search'=>request()->search]) }}" type="submit" class="btn btn-primary">Sửa</a>
        </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4 mb-md-0">

        <div id="mdb-lightbox-ui"></div>

        <div class="mdb-lightbox">

            <div class="row product-gallery mx-1">

                <div class="col-12 mb-4">
                    @if($product->images->count() == 0)
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid img-max"
                             alt="Item">
                    @else
                        <img
                            src="{{ asset('images/product/'.$product->images->first()->image_path) }}"
                            class="img-fluid img-max" alt="Item">
                    @endif
                </div>
                <div class="col-12">
                    <div class="row">
                        {{-- @foreach ($product->images as $image)
                        <div class="col-3">
                            <div class="rounded gallery-item">
                                <img src="{{ $image->image_path }}" class="img-fluid">
                            </div>
                        </div>
                        @endforeach --}}
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="col-md-6">

        <h5>{{ $product->name }}</h5>
        <p class="mb-2 text-muted text-uppercase small">{{ $product->category->name }}</p>
        <p><span class="mr-1"><strong>{{ $product->price }} VND</strong></span></p>
        <p class="pt-1">{{ $product->description }}</p>

        <hr>
        <div class="table-responsive mb-2">
            <table class="table table-sm table-borderless">
                <tbody>
                    <tr>

                        <td class="pl-0 mb-4 w-25">Mã sản phẩm</td>
                        <td class="pb-0">{{ $product->id }}</td>
                    <tr>
                    <tr>

                        <td class="pl-0 mb-4 w-25"></td>
                        <td class="pb-0">{{ $product->supplier->name }}</td>
                    <tr>
                        <td class="pl-0 mb-4 w-25">Số lượng</td>
                        <td class="pb-0">{{ $product->quantity }}</td>
                    </tr>
                    <tr>

                        <td class="pl-0 mb-4 w-25">Trạng thái</td>
                        <td class="pb-0 badge rounded-pill alert-success">{{ $product->status == 1 ? 'Đang bán' : 'Dừng bán' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@push('js')
<script src="{{ asset('js/product/script.js') }}"></script>
@endpush
