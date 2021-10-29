@extends('layouts.admin.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Danh sách danh mục</h2>
    <div>
        <a href="{{ route('category.create',  ['page'=>request()->page, 'search'=>request()->search]) }}" type="submit" class="btn btn-primary">Thêm danh mục</a>
    </div>
</div>
<section class="content-main">
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                </div>
                <div class="col-md-4 col-6">
                    <form action="{{ route('category.list') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Tìm Danh sách" value="{{ request()->search }}">
                            <button class="btn btn-light bg" type="submit">
                                <i class="material-icons md-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->

        <div class="card-body">
              @if ($categories->isEmpty())
                <div>Không có danh mục nào</div>
            @endif
            @foreach ($categories as $category)
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                        <a class="itemside" href="{{ route('category.show', ['id'=>$category->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                            <div class="info">
                                <h6 class="mb-0">{{ $category->name }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-4 col-date">
                        <span>{{ $category->created_at }}</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-4 col-action">
                        <div class="dropdown float-end">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('category.show', ['id'=>$category->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Xem chi tiết</a>
                                <a class="dropdown-item" href="{{ route('category.edit', ['id'=>$category->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Sửa</a>
                                <form class="delete-category" data-id="{{ $category->id }}" data-name={{ $category->name }} action="{{ route('category.destroy', ['id'=>$category->id]) }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"style="outline:none">Xóa</button>
                                </form>
                            </div>
                        </div> <!-- dropdown // -->
                    </div>
                </div> <!-- row .// -->
            </article> <!-- itemlist  .// -->
            @endforeach

            <nav class="float-end mt-4" aria-label="Page navigation">
                <ul class="pagination">
                    @if ($categories->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Trước</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link active" href="{{ $categories->withQueryString()->previousPageUrl() }}" rel="prev">← Trước</a>
                        </li>
                    @endif
                    <li class="page-item disabled"><a class="page-link" href="#">{{ $categories->currentPage() }}</a></li>

                    @if ($categories->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $categories->withQueryString()->nextPageUrl() }}">Sau →</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link active" href="#" rel="next">Sau</a>
                        </li>
                    @endif
                </ul>
            </nav>

        </div> <!-- card-body end// -->
    </div> <!-- card end// -->

</section>
@endsection

@section('javascript')
<script src="{{ asset('js/category/script.js') }}"></script>
@endsection
