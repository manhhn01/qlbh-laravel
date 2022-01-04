var ctxOrder = document.getElementById("chartOrder").getContext("2d");
var chart1 = new Chart(ctxOrder, {
    type: "line",

    data: {
        labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
        datasets: [{
            label: "Đơn hàng",
            borderColor: "rgba(255, 205, 86, 0.8)",
            backgroundColor: "rgba(255, 205, 86, 0.2)",
            data: [0, 1, 0, 3, 0, 5, 0, 18, 0, 1, 0, 0],
        }],
    },
    options: {},
});

var ctxRevenue = document.getElementById("chartRevenue").getContext("2d");
var chart2 = new Chart(ctxRevenue, {
    type: "line",

    data: {
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
        datasets: [{
            label: "Lợi nhuận",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 0.8)",
            data: [5, 1, 5, 3, 7, 5, 0, 10, 0, 1, 0, 9],
        }],
    },
    options: {},
});

$('#datepicker1').datepicker({
    format: 'yyyy/mm/dd',
}).on('change', function () {
    $('#datepicker3').val("0");
});

$('#datepicker2').datepicker({
    format: 'yyyy/mm/dd',
}).on('change', function () {
    console.log("run");
    $('#datepicker3').val("0");
});

$('#datepicker3').on('change', function () {
    $('#datepicker1').val("");
    $('#datepicker2').val("");
});
