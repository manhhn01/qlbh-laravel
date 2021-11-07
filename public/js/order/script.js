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

//bind event for template
const bindEvents = () => {
    // input coupon event
    $(".coupon-input").on("input", function () {
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
    $(".product-search-input").on(
        "input",
        debounce(function(){
            getProduct($(this).val());
        }, 500)
    );

    //button add product event
    $(".add-order-product-btn").on("click", function () {
        const idSku = $(".product-search-input").val();
        addProduct(idSku);
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
            $("#productPreview").empty();
            $("#productLoad")
                .removeClass("d-none")
                .addClass("d-flex justify-content-center");
        },
        complete: function () {
            $("#productLoad")
                .addClass("d-none")
                .removeClass("d-flex justify-content-center");
        },
        success: (result) => {
            const data = result.data;
            const error = result.error;
            if (data) {
                $("#productPreview").html(`
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
    $.ajax({
        method: "post",
        url: "/product/ajax",
        data: {
            id_sku: idSku,
        },
        success: (result) => {
            const data = result.data;
            const error = result.error;
            if (data) {
                if (data.quantity <= 0) {
                    alertMsg("Sản phẩm đã hết hàng");
                } else if (
                    $("#orderProducts>tbody").find(
                        `[data-id=${data.product_id}]`
                    ).length !== 0
                ) {
                    alertMsg("Sản phẩm đã có trong hóa đơn");
                } else {
                    const productRow = `
                                                <tr data-id=${data.product_id}>
                                                <input type="hidden" name="product[0][id]" value="${data.product_id}">
                                                <input type="hidden" name="product[0][sku]" value="${data.sku}">
                                                <th scope="row">
                                                    ${data.product_name}
                                                </th>
                                                <td>
                                                    ${data.sku}
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" min="1" max="${data.quantity}" name="product[0][qty]" value="1">
                                                </td>
                                                <td>
                                                    ${data.price} đ
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger delete-order-product-btn" onclick="removeProduct(${data.product_id})">Xóa</button>
                                                </td>
                                                </tr>
                                                `;
                    $("#orderProducts > tbody").append(productRow);
                }
            }

            if (error) {
                console.log(error.code, error.message);
                if (error.code === 404) {
                    alertMsg("Không tìm thấy sản phẩm");
                }
            }
        },
    });
};
//add alert message
const alertMsg = (msg) => {
    const alert = $(
        `<div class="alert alert-danger" id="orderListAlerts" role="alert">${msg}</div>`
    );
    $("#orderListAlerts").append(alert);
    setTimeout(() => {
        alert.remove();
    }, 2000);
};

//remove product from list
const removeProduct = (id) => {
    $(`[data-id=${id}]`).remove();
};

//debounce for input
const debounce = function(callback, wait) {
    let timeout;
    return function(...args) {
        const context = this
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            callback.apply(context, args);
        }, wait);
    };
};
