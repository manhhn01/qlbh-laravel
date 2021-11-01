// new category & new supplier
$(() => {
    console.log("ready");
    $("#supplierSelect").on("change", function () {
        console.log(this.value);
        if (this.value == "add") {
            $("#supplierNew").show();
        } else {
            $("#supplierNew").hide();
        }
    });
    $("#categorySelect").on("change", function () {
        console.log(this.value);
        if (this.value == "add") {
            $("#categoryNew").show();
        } else {
            $("#categoryNew").hide();
        }
    });

    //confirm delete
    $(".delete-product").submit(function () {
        if (
            confirm(
                "Bạn có chác chắn muốn xóa sản phẩm " +
                    this.dataset.name +
                    this.dataset.id
            )
        ) {
            console.log("saved to the database.");
            return true;
        }
        console.log("not saved to the database.");
        return false;
    });

    $(".status-select").on("change", function (){
        $(".form-filter").submit();
    })
});
