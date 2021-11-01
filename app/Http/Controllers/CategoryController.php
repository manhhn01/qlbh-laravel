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
        if ($request->has(["search"])) {
            $filter["name"] = $request->search;
        }
        $categories = $this->categoryRepo->page(2, $filter ?? null);
        return view(
            'admin.category.index',
            ['categories' => $categories]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryCreateRequest $request)
    {
        $attributes = $request->only(['name', 'description']);

        $this->categoryRepo->create($attributes);

        return back()->with('info', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return View | RedirectResponse
     */
    public function show(int $id, Request $request)
    {
        //filter products
        $filter["name"] = $request->search;
        $filter["status"] = $request->status;

        try {
            $category = $this->categoryRepo->find($id);
            $products = $this->categoryRepo->getProductsPage(2, $id, $filter);
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
     * @param int $id
     * @return View | RedirectResponse
     */
    public function edit($id)
    {
        try {
            $category = $this->categoryRepo->find($id);
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
        $attributes = $request->only(['name', 'description']);

        try{

        $this->categoryRepo->update($id, [
            'name' => $attributes['name'],
            'description' => $attributes['description']
        ]);

        } catch (ModelNotFoundException $e){
            return back()->withErrors(['message' => 'Không tìm thấy sản phẩm']);
        }
        return redirect(route('category.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->categoryRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy danh mục để xóa']);
        }
        return back()->with('info', 'Xóa danh mục thành công');
    }
}
