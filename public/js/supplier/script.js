$(() => {
    //confirm delete
    $(".delete-supplier").submit(function () {
        if (
            confirm(
                "Bạn có chác chắn muốn xóa nhà cung cấp " +
                this.dataset.name +
                "có id " +
                this.dataset.id +
                '? Xóa nhà cung cấp này sẽ xóa toàn bộ sản phẩm từ nhà cung cấp này'
            )
        ) {
            console.log("saved to the database.");
            return true;
        }
        console.log("not saved to the database.");
        return false;
    });
});
