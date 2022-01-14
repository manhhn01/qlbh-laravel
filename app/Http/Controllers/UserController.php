<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware(['auth', 'admin']);
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if ($request->has(['search'])) {
            $filter['email'] = $request->search;
        }
        $users = $this->userRepo->pageUsersByRole(1,  5, $filter ?? null);

        return view(
            'admin.user.index',
            ['users' => $users]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View | RedirectResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserCreateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UserCreateRequest $request)
    {
        $attributes = $request->except('_token');
        foreach($attributes['emails'] as $index => $email){
            if(empty($attributes['passwords'])){
                User::updateOrCreate([
                    'email'=>$email
                ], [
                    'first_name'=>$attributes['first_names'][$index],
                    'last_name'=>$attributes['last_names'][$index],
                    'role'=>1
                ]);
            }
            else{
                User::updateOrCreate([
                    'email'=>$email
                ], [
                    'first_name'=>$attributes['first_names'][$index],
                    'last_name'=>$attributes['last_names'][$index],
                    'password'=>bcrypt($attributes['passwords'][$index]),
                    'role'=>1
                ]);
            }
        }

        if(isset($attributes['new_emails'])){
            foreach($attributes['new_emails'] as $index => $email){
                User::create([
                    'email'=>$email,
                    'first_name'=>$attributes['new_first_names'][$index],
                    'last_name'=>$attributes['new_last_names'][$index],
                    'password'=>bcrypt($attributes['new_passwords'][$index]),
                    'role'=>1
                ]);
            }
        }

        return redirect(route('user.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy()
    {
        $id = request()->id;
        try {
            $this->userRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
            'error'=> "Khong tim thay nguoi dung"
        ]);
        }

        return response()->json([
            'status'=> 'success'
        ]);
    }
}
