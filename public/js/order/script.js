$(() => {
    //disable blank search input
    $(".form-filter").on("submit", function (e) {
        $(this)
            .find(":input")
            .filter(function () {
                return !this.value;
            })
            .attr("disabled", "disabled");
        return true;
    });

    $("#buy_place")
        .on("change", function () {
            if (this.value === "online") {
                $(".order-info-container").html($("#onTemplate").html());
            } else if (this.value === "offline") {
                $(".order-info-container").html($("#offTemplate").html());
            }

            bindEvents(); //bind event to new element
        })
        .trigger("change");
});
/* end ready */

const bindEvents = () => {
    // input coupon event
    $(".coupon-input").on("input", function () {
        console.log("input");
        // todo ajax
        let cloneCard = `
            <div class="card">
            <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            </div>
            </div>
            `;
        $(".coupon-card-container").html(cloneCard);
    });

    //input product id event
    $(".product-search-input").on("input", function () {
        getProduct($(this).val());
    });

    //button add product event
    $(".add-order-product-btn").on("click", function () {
        const idSku = $(".product-search-input").val();
    });
};

const getProduct = (idSku) => {
    $.ajax({
        method: "post",
        url: "/product/ajax",
        data: {
            id_sku: idSku,
        },
        beforeSend: function () {
            $("#product-preview").empty();
            $("#productLoad").removeClass("d-none").addClass("d-flex justify-content-center");
        },
        complete: function () {
            $("#productLoad").addClass("d-none").removeClass("d-flex justify-content-center");
        },
        success: (result) => {
            const data = result.data;
            const error = result.error;
            if (data) {
                $("#product-preview").html(`
                    <div class="card">
                    <div class="card-body">
                    <p class="card-text">Id: ${data.product_id}  SKU: ${data.sku}</p>
                    <h5 class="card-title">${data.product_name}</h5>
                    <p class="card-text text-danger">${data.price} đ</p>
                    <p class="card-text">Số lượng: ${data.quantity}</p>
                    </div>
                    </div>
                `);
            } else if (error) {
                console.log(error.code, error.message);
            }
        },
    });

};

const addProduct = (idSku) => {
    //todo ajax kiểm tra số lượng sản phẩm trong kho
    //todo thêm vào bảng
    const productRow = `
        <tr>
            <input type="hidden" name="product[0][name]" value="{product-name}">
            <input type="hidden" name="product[0][sku]" value="{product-sku}">
            <input type="hidden" name="product[0][qty]" value="{qty}">
            <th scope="row">
                Mark
            </th>
            <td>
                SKU21312345
            </td>
            <td>
                @mdo
            </td>
            <td>@mdo</td>
            <td>
                <button type="button" class="btn btn-danger delete-order-product-btn-">Xóa</button>
            </td>
        </tr>
    `

    //todo bind event vào button xóa
};
