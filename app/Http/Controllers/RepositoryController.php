<?php

namespace App\Http\Controllers;

use App\Models\Repository;
//use Illuminate\Http\Request;
use App\Http\Requests\RepositoryStoreRequest;

class RepositoryController extends Controller
{
    public function index()
    {
        return view('repositories.index', [
            //'repositories' => $request->user()->repositories
            'repositories' => auth()->user()->repositories
        ]);
    }

    public function show(Repository $repository)
    {
        $this->authorize('pass', $repository);
        /*if($request->user()->id != $repository->user_id){
            abort(403); // Nos ayuda a disparar estados
        }*/

        return view('repositories.show', compact('repository'));
    }

    public function create()
    {
        return view('repositories.create');
    }

    public function store(RepositoryStoreRequest $request)
    {
        /*$request->validate([
            'url' => 'required',
            'description' => 'required',
        ]);*/

        $request->user()->repositories()->create($request->all());

        return redirect()->route('repositories.index');
    }

    public function edit(Repository $repository)
    {
        $this->authorize('pass', $repository);
        /*if($request->user()->id != $repository->user_id){
            abort(403); // Nos ayuda a disparar estados
        }*/

        return view('repositories.edit', compact('repository'));
    }

    public function update(RepositoryStoreRequest $request, Repository $repository)
    {
        /*$request->validate([
            'url' => 'required',
            'description' => 'required',
        ]);*/

        $this->authorize('pass', $repository);
        /*if($request->user()->id != $repository->user_id){
            abort(403); // Nos ayuda a disparar estados
        }*/

        $repository->update($request->all());

        return redirect()->route('repositories.edit', $repository);
    }

    public function destroy(Repository $repository)
    {
        $this->authorize('pass', $repository);
        /*if($request->user()->id != $repository->user_id){
            abort(403); // Nos ayuda a disparar estados
        }*/

        $repository->delete();

        return redirect()->route('repositories.index',);
    }
}
