<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->middleware(['auth', 'admin']);

        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $search_keyword = $request->search;

        $categories = $this->categoryRepo->page(10, $search_keyword);
        return view(
            'admin.category.index',
            ['categories' =>$categories]
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
