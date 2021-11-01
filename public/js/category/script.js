// new category & new brand
$(() => {
    //confirm delete
    $(".delete-category").submit(function () {
        if (
            confirm(
                "Bạn có chác chắn muốn xóa danh mục " +
                    this.dataset.name +
                    "có id " +
                    this.dataset.id +
                    '? Xóa danh mục này sẽ xóa toàn bộ sản phẩm trong danh mục'
            )
        ) {
            console.log("saved to the database.");
            return true;
        }
        console.log("not saved to the database.");
        return false;
    });
    // $(this).on('click', function(){
    // alert("Bạn có chác chắn muốn xóa sản phẩm", this.data.id);
    // });
});
