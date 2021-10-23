@extends('layouts.admin.app')
@section('content-main')
<form action="{{ route('category.create') }}" method="post" enctype="multipart/form-data">
    @csrf()
    <div class="content-header">
        <h2 class="content-title"> Thêm danh sách</h2>
        <div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="form-label">Mô tả</label>
                        <textarea type="text" placeholder="Nhập ở đây..." class="form-control" name="description" id="name" value="{{ old('description') }}"></textarea>
                    </div>
                </div>
            </div> <!-- card end// -->
    </div> <!-- card end// -->
    </aside> <!-- col end// -->
    </div> <!-- row end// -->
</form>

@endsection


@push('js')
@endpush
