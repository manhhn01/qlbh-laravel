<div class="row mb-4">
    <div class="mb-3">Danh sách sản phẩm</div>
    <div class="col-lg-6">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Sản phẩm</th>
                <th scope="col">SKU</th>
                <th scope="col">SL</th>
                <th scope="col">Giá</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            {{-- Danh sách sản phẩm đc trả về nếu như post form gặp lỗi --}}
            @isset($orderProducts)
            @foreach($orderProducts as $product)
                <tr>
                    <input type="hidden" name="product[0][name]" value="{{$product->name}}">
                    <input type="hidden" name="product[0][sku]" value="{{$product->sku}}">

                    <th scope="row">
                        Mark
                    </th>
                    <td>
                        SKU21312345
                    </td>
                    <td>
                        <input type="number" min="{{$product->min_qty}}" max="{{$product->max_qty}}" name="product[0][qty]" value="{{$product->qty}}"> {{-- qty của sản phẩm trong order, khác vs quantity trong kho --}}
                    </td>
                    <td>
                        100.000 đ
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger delete-order-product-btn-">Xóa</button>
                    </td>
                </tr>
            @endforeach
            @endisset
            </tbody>
        </table>
    </div>
    <div class="col-lg-6 mb-3">
        <label class="form-label">Thêm sản phẩm</label>
        <div class="alert alert-danger" role="alert">
            Không tìm thấy sản phẩm
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <input type="text" class="form-control product-search-input" placeholder="Mã SP hoặc SKU">
            </div>
            <div class="col-md-4 mb-3 d-grid">
                <button type="button" class="btn btn-primary add-order-product">Thêm</button>
            </div>
        </div>
        <div id="productLoad" class="d-none">
            <div class="d-flexjustify-content-center">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div id="product-preview">
        </div>
    </div>
</div>
