@extends('layouts.app')
@section('content-main')
<form action="{{ route('update-product', ['id' => $id, 'page' => request()->page]) }}" method="post" enctype="multipart/form-data">
    @csrf()
    <div class="content-header">
        <h2 class="content-title"> Sửa sản phẩm</h2>
        <div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-8 col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="name" class="form-label">Product name</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name" value="{{ $product->name }}">
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
                        <label class="form-label">Mô tả</label>
                        <textarea placeholder="Nhập ở đây..." class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
                    </div>
                </div>
            </div> <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div>
                        <label class="form-label">Cập nhật ảnh sản phẩm</label>
                        <input class="form-control" name="images[]" type="file" multiple value="not change">
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
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option {{ $product->status==1?'selected':'' }} value="1">Đang bán</option>
                            <option {{ $product->status==0?'selected':'' }} value="0">Dừng bán</option>
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
    </div> <!-- row end// -->
</form>

@endsection


@push('js')
    <script src="{{ asset('js/product/script.js') }}"></script>
@endpush
