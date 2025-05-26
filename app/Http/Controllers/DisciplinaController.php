<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disciplina;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disciplinas = Disciplina::where('created_by', auth()->id())->get();
        return view('disciplinas.index', compact('disciplinas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('disciplinas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'descricao'  => 'nullable|string',
        ]);

        $data['created_by'] = Auth::id();

        $disciplina = Disciplina::create($data);

        return redirect()
            ->route('disciplinas.show', $disciplina)
            ->with('success', 'Disciplina criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        return view('disciplinas.show', ['disciplina' => $disciplina]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $disciplina = Disciplina::findOrFail($id);
        return view('disciplinas.edit', compact('disciplina'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $disciplina = Disciplina::findOrFail($id);
        $data = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);
        
        if ($disciplina->created_by !== Auth::id()) {
            abort(403);
        }

        $disciplina->update($data);

        return redirect()
            ->route('disciplinas.show', $disciplina)
            ->with('success', 'Disciplina atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $disciplina = Disciplina::findOrFail($id);
        
        if ($disciplina->created_by !== Auth::id()) {
            abort(403);
        }

        $disciplina->delete();

        return redirect()
            ->route('disciplinas.index')
            ->with('success', 'Disciplina excluída com sucesso!');
    }
}
