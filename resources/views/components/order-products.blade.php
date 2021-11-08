<div class="row mb-4">
    <div class="mb-3">Danh sách sản phẩm</div>
    <div class="col-lg-8">
        <table class="table table-hover" id="orderProducts">
            <thead>
            <tr>
                <th scope="col" width="40%">Sản phẩm</th>
                <th scope="col" width="20%">SKU</th>
                <th scope="col" width="20%">SL</th>
                <th scope="col" width="10%">Giá</th>
                <th scope="col" width="10%"></th>
            </tr>
            </thead>
            <tbody>
            {{-- Danh sách sản phẩm đc trả về nếu như post form gặp lỗi --}}
            @isset($products)
                @foreach($products as $product)
                    <tr data-id={{$product['product_id']}}>
                        <input type="hidden" name="products[{{$product['product_id']}}][product_id]" value="{{$product['product_id']}}">
                        <input type="hidden" name="products[{{$product['product_id']}}][name]" value="{{$product['name']}}">
                        <input type="hidden" name="products[{{$product['product_id']}}][sku]" value="{{$product['sku']}}">
                        <input type="hidden" name="products[{{$product['product_id']}}][max_qty]" value="{{$product['max_qty']}}">
                        <input type="hidden" name="products[{{$product['product_id']}}][price]" value="{{$product['price']}}">

                        <th scope="row">
                            {{ $product['name'] }}
                        </th>
                        <td>
                            {{ $product['sku'] }}
                        </td>
                        <td>
                            <input class="form-control" type="number" min="1"
                                   max="{{$product['max_qty']}}" name="products[{{$product['product_id']}}][qty]"
                                   value="{{$product['qty']}}">
                        </td>
                        <td>
                            {{ $product['price'] }} đ
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete-order-product-btn" onclick="removeProduct{{$product['product_id']}}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            @endisset
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
            <div class="d-flexjustify-content-center">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div id="productPreview"></div>
    </div>
</div>
