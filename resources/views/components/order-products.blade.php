<div class="row mb-4">
    <div class="mb-3">Danh sách sản phẩm</div>
    <div class="col-lg-8">
        <table class="table table-hover" id="orderProducts">
            <thead>
            <tr>
                <th scope="col" style="width: 30%">Sản phẩm</th>
                <th scope="col" style="width: 20%">SKU</th>
                <th scope="col" style="width: 20%">SL</th>
                <th scope="col" style="width: 20%">Giá</th>
                <th scope="col" style="width: 10%"></th>
            </tr>
            </thead>
            <tbody>
            {{-- Danh sách sản phẩm đc trả về nếu như post form gặp lỗi --}}
            @isset($products)
                @foreach($products as $product)
                    <tr data-id={{$product['product_id']}} data-price={{ $product['product_id'] }}>
                        <input type="hidden" name="products[{{$product['product_id']}}][product_id]" value="{{$product['product_id']}}">
                        <th scope="row">
                            {{ $product['name'] }}
                        </th>
                        <td>
                            {{ $product['sku'] }}
                        </td>
                        <td>
                            <input class="form-control" type="number" min="1"
                                   max="{{$product['max_qty']}}" name="products[{{$product['product_id']}}][quantity]"
                                   value="{{$product['quantity']}}">
                        </td>
                        <td>
                            {{ number_format($product['price'], 0, ",", ".")}} đ
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete-order-product-btn" onclick="removeProduct{{$product['product_id']}}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            @endisset

            <tr>
                <td colspan="5" class="text-end fs-5">Giảm giá: <span id="discountAmount">0 đ</span></td>
            </tr>
            <tr>
                <td colspan="5" class="text-end fs-5">Tổng số tiền: <span class="text-danger fs-4 fw-bolder" id="totalPrice">0 đ</span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-4 mb-3">
        <label class="form-label">Thêm sản phẩm</label>
        <div class="row">
            <div class="col-md-8 mb-3">
                <input type="text" class="form-control product-search-input" placeholder="Mã SP hoặc SKU">
            </div>
            <div class="col-md-4 mb-3 d-grid">
                <button type="button" class="btn btn-primary add-order-product-btn">Thêm</button>
            </div>
            <div id="orderListAlerts"></div>
        </div>
        <div id="productLoad" class="d-none">
            <div class="d-flex justify-content-center">
                <div class="lds-ring">
                    <div></div><div></div><div></div><div></div>
                </div>
            </div>
        </div>
        <div id="productPreview"></div>
    </div>
</div>
