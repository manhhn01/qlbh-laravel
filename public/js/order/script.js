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
    $(".coupon-input").on("input", debounce(function () {
        getCoupon($(this).val());
    }, 500));

    //input product id event
    $(".product-search-input").on(
        "input",
        debounce(function () {
            getProduct($(this).val());
        }, 500)
    );

    //button add product event
    $(".add-order-product-btn").on("click", function () {
        const idSku = $(".product-search-input").val();
        addProduct(idSku);
    });
};

const getCoupon = (idName) => {
    $.ajax({
        method: "post",
        url: "/coupon/ajax",
        data: {
            id_name: idName,
        },
        beforeSend: ()=>{
            $(".coupon-card-container").empty();
            $("#couponLoad")
                .removeClass("d-none")
                .addClass("d-flex justify-content-center");
        },
        complete: function () {
            $("#couponLoad")
                .addClass("d-none")
                .removeClass("d-flex justify-content-center");
        },
        success: (result) => {
            const {
                data,
                error
            } = result;
            if (data) {
                const couponCard = `
                <div class="card">
                <input type="hidden" name="coupon_id" value="${data.coupon_id}"">
                <div class="card-header text-center">
                    ${data.coupon_name}
                </div>
                <div class="card-body">
                <h5 class="card-title">Giảm
                    ${data.discount} %
                </h5>
                <p class="card-text">
                    ${data.description}
                </p>
                <div class="card-footer text-muted text-center">
                    Hết hạn vào: ${data.expired_at}
                </div>
                </div>
                </div>
                `;
                $(".coupon-card-container").html(couponCard);
            }

            if (error) {
                console.log(error.code, error.message);
            }
        },
    });
}

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
            const {
                data,
                error
            } = result;
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
                                    <input type="hidden" name="products[${data.product_id}][product_id]" value="${data.product_id}">
                                    <input type="hidden" name="products[${data.product_id}][name]" value="${data.product_name}">
                                    <input type="hidden" name="products[${data.product_id}][sku]" value="${data.sku}">
                                    <input type="hidden" name="products[${data.product_id}][max_qty]" value="${data.quantity}">
                                    <input type="hidden" name="products[${data.product_id}][price]" value="${data.price}">
                                    <th scope="row">
                                        ${data.product_name}
                                    </th>
                                    <td>
                                        ${data.sku}
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" min="1" max="${data.quantity}" name="products[${data.product_id}][qty]" value="1">
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
const debounce = function (callback, wait) {
    let timeout;
    return function (...args) {
        const context = this
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            callback.apply(context, args);
        }, wait);
    };
};
