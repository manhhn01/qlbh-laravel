<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $search_param = request()->search;
        $data = [];
        if (!empty($search_param)) {
            $categories = Category::where('name', 'like', '%' . $search_param . '%')->orderBy('name');
            $data['categories'] = $categories->paginate(10);
        } else {
            $data['categories'] = Category::paginate(10);
        }

        return view(
            'admin.category.index',
            $data
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryCreateRequest $request)
    {
        $data = $request->only(['name', 'description']);


        $Category = Category::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        return back()->with('info', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View | RedirectResponse
     */
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            $products = Product::where('category_id', $id)->paginate(10);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy danh mục']);
        }
        return view('admin.category.show', [
            'id' => $id,
            'category' => $category,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy danh mục']);
        }
        return view('admin.category.edit', [
            'id' => $id,
            'category' => $category,
        ]);
    }

    public function update(CategoryCreateRequest $request, $id)
    {
        $data = $request->only(['name', 'description']);
        Category::updateOrCreate(['id' => $id], [
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        return redirect(route('category.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            Category::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy danh mục để xóa']);
        }
        return back()->with('info', 'Xóa danh mục thành công');
    }
}
