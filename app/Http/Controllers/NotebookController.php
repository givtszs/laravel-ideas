<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\StoreNotebookRequest;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notebooks = Notebook::paginate(20);
        return view('notebooks.index', compact('notebooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notebooks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotebookRequest $request)
    {
        // Create a new notebook model
        $data = $request->validated();
        $data['creator_id'] = Auth::id();

        if ($request->has('cover') && $data['cover']) {
            $path = $data['cover']->store('notebook_cover', 'public');
            $data['cover'] = $path;
        }

        $notebook = Notebook::create($data);
        $this->join($notebook);

        // Redirect back to the /notebooks
        return redirect()->route('notebooks.index')->with('success', 'Notebook is created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notebook $notebook)
    {
        $ideas = $notebook->ideas()->latest()->get();
        return view('notebooks.show', compact('notebook', 'ideas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function join(Notebook $notebook)
    {
        // check if the current user is the creator of the notebook and assign him the notebook-admin role
        if (Auth::id() === $notebook->creator_id) {
            $roleId = Role::where('name', RolesEnum::NotebookAdmin->value)->first()->id;
            $attrs = ['role_id' => $roleId];
        }
        $notebook->users()->attach(Auth::id(), $attrs ?? []);

        return back()->with('success', 'Joined the notebook successfully');
    }

    public function leave(Notebook $notebook)
    {
        $notebook->users()->detach(Auth::id());
        return redirect()->route('notebooks.index')->with('success', 'Left the notebook successfully');
    }


}
