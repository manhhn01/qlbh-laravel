@extends('layouts.admin.app')
@section('content-main')
<form action="{{ route('supplier.update', ['id' => $id, 'page' => request()->page]) }}" method="POST">
    @csrf()
    <div class="content-header">
        <h2 class="content-title"> Sửa nhà cung cấp</h2>
        <div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-8 col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="name" class="form-label">Tên nhà cung cấp</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name" value="{{ $supplier->name }}">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="form-label">Mô tả nhà cung cấp</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="description" id="description" value="{{ $supplier->description }}">
                    </div>
                </div>
            </div> <!-- card end// -->

        </div> <!-- col end// -->
    </div> <!-- row end// -->
</form>

@endsection

@push('js')
@endpush
