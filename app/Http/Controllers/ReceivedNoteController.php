<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteCreateRequest;
use App\Repositories\ReceivedNote\ReceivedNoteRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReceivedNoteController extends Controller
{
    protected $receivedNoteRepo;

    public function __construct(ReceivedNoteRepositoryInterface $receivedNoteRepo)
    {
        $this->middleware(['auth', 'admin']);

        $this->receivedNoteRepo = $receivedNoteRepo;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if ($request->has(['status'])) {
            $filter['status'] = $request->status;
        }
        $received_note = $this->receivedNoteRepo->page(5, $filter ?? null);

        return view(
            'admin.received-note.index',
            ['received_note' => $received_note]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.received-note.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NoteCreateRequest $request
     * @return RedirectResponse
     */
    public function store(NoteCreateRequest $request)
    {
        $attributes = $request->only(['manager_id', 'deliver_name', 'status', 'receive_at', 'products', 'note']);

        try {
            $this->receivedNoteRepo->create($attributes);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['messages' => $e->getMessage()])
                ->withInput($attributes);
        }

        return back()->with('info', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View | RedirectResponse
     */
    public function show(int $id)
    {
        try {
            $note = $this->receivedNoteRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy phiếu nhập']);
        }

        return view('admin.received-note.show', [
            'id' => $id,
            'note' => $note,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse | View
     */
    public function edit(int $id)
    {
        try {
            $note = $this->receivedNoteRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Không tìm thấy phiếu nhập']);
        }

        return view('admin.received-note.edit', [
            'id' => $id,
            'note' => $note,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->only(['manager_id', 'deliver_name', 'status', 'receive_at', 'products', 'note']);

        try {
            $this->receivedNoteRepo->update($id, $attributes);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect(route('received-note.list', ['page' => request()->page]))->with('info', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
