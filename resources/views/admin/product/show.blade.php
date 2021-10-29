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
                    @if ($product->images->first()->image_path == '')
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

                        <td class="pl-0 mb-4 w-25">Nhãn hiệu</td>
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


{{-- <div class="row mb-4">
        <div class="col-xl-8 col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <div>Product name: {{ $product->name }}</div>
</div>
<div class="mb-4">
    <label for="product_brand" class="form-label">Brand</label>
    <select name="supplier" class="form-select" id="brandSelect">
        <option selected disabled>Chọn brand</option>
        <option value="add">--Thêm mới--</option>
        @foreach ($suppliers as $supplier)
        <option {{ $supplier->id==$product->supplier_id ? 'selected':'' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
        @endforeach
    </select>
</div>

<div id="brandNew" style="display:none">
    <label for="new_brand" class="form-label">Nhãn hiệu mới</label>
    <input type="text" placeholder="Nhập ở đây..." class="form-control" name="new_supplier" id="new_brand">
</div>
</div>
</div> <!-- card end// -->
<div class="card mb-4">
    <div class="card-body">
        <div>
            <label class="form-label">Description</label>
            <textarea placeholder="Nhập ở đây..." class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
        </div>
    </div>
</div> <!-- card end// -->
<div class="card mb-4">
    <div class="card-body">
        <div>
            <label class="form-label">Ảnh sản phẩm</label>
            <input class="form-control" name="image" type="file" multiple>
        </div>
    </div>
</div> <!-- card end// -->
</div> <!-- col end// -->
<aside class="col-xl-4 col-lg-4">
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-4">
                <label class="form-label">Số lượng</label>
                <input type="text" placeholder="Nhập ở đây..." name="quantity" class="form-control" value="{{ $product->quantity }}">
            </div>
            <div class="mb-4">
                <label class="form-label">Giá</label>
                <input type="text" placeholder="Nhập ở đây..." name="price" class="form-control" value="{{ $product->price }}">
            </div>
            <div class="mb-4">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option {{ $product->status==1?'selected':'' }} value="1">Published</option>
                    <option {{ $product->status==0?'selected':'' }} value="0">Draft</option>
                </select>
            </div>

            <hr>

            <h5 class="mb-3">Danh mục</h5>
            <div class="mb-3">
                <select class="form-select" name="category" id="categorySelect">
                    <option selected disabled>Chọn danh mục</option>
                    <option value="add">--Thêm mới--</option>
                    @foreach ($categories as $category)
                    <option {{ $category->id==$product->category_id ? 'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="categoryNew" style="display:none">
                <label for="new_category" class="form-label">Danh mục mới</label>
                <input type="text" placeholder="Nhập ở đây..." class="form-control" name="new_category" id="new_category">
            </div>
        </div>
    </div>
    </div> <!-- card end// -->
</aside> <!-- col end// -->
</div> <!-- row end// --> --}}

@endsection


@push('js')
<script src="{{ asset('js/product/script.js') }}"></script>
@endpush
