@extends('layouts.admin.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Hi, {{ Auth::user()->first_name }} </h2>
    <div>
        <a href="#" class="btn btn-primary">Tạo báo cáo</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-monetization_on"></i></span>
                <div class="text">
                    <h6 class="mb-1">Tổng lợi nhuận</h6> <span>$0</span>
                </div>
            </article>
        </div> <!-- card  end// -->
    </div> <!-- col end// -->
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                <div class="text">
                    <h6 class="mb-1">Tổng đơn hàng</h6> <span>0</span>
                </div>
            </article>
        </div> <!-- card end// -->
    </div> <!-- col end// -->
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-shopping_basket"></i></span>
                <div class="text">
                    <h6 class="mb-1">Tổng sản phẩm</h6> <span>0</span>
                </div>
            </article>
        </div> <!--  end// -->
    </div> <!-- col end// -->
</div> <!-- row end// -->


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <article class="card-body">
                <h5 class="card-title ">Biểu đồ thống kê</h5>
                <div class="row mb-3 justify-content-center">
                    <div class="col-md-6 d-flex">
                        <input id="datepicker1" type="text" class="form-control" placeholder="Từ ngày">
                        <input id="datepicker2" type="text" class="form-control ms-3" placeholder="Đến ngày">
                        <select id="datepicker3" class="ms-3 form-select form-select-sm" aria-label=".form-select-lg example">
                            <option value="0" disabled>-- Chọn --</option>
                            <option value="1" selected>7 ngày qua</option>
                            <option value="2">Tháng này</option>
                            <option value="3">Tháng trước</option>
                            <option value="3">2 Tháng trước</option>
                        </select>
                        <button type="button" class="btn btn-primary ms-3 px-4">Lọc</button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                            <canvas height="400" id="chartOrder" style="display: block; height: 258px; width: 646px;" width="895" class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="col-6">
                            <canvas height="400" id="chartRevenue" style="display: block; height: 258px; width: 646px;" width="895" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </article> <!-- card-body end// -->
        </div> <!-- card end// -->
    </div> <!-- col end// -->

</div> <!-- row end// -->


<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Đơn hàng gần đây</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td>2323</td>
                        <td><b>ABC</b></td>
                        <td>test@example.com</td>
                        <td>0đ</td>
                        <td><span class="badge rounded-pill alert-warning">Đang giao</span></td>
                        <td>07.010.2021</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-light">Chi tiết</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2323</td>
                        <td><b>CDE</b></td>
                        <td>test@example.com</td>
                        <td>0đ</td>
                        <td><span class="badge rounded-pill alert-success">Đã giao</span></td>
                        <td>07.010.2021</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-light">Chi tiết</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- table-responsive end// -->
    </div> <!-- card-body end// -->
</div> <!-- card end// -->
@endsection()

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="{{ asset('js/date-picker.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/script.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('css/date-picker-boostrap.css') }}">
@endpush
