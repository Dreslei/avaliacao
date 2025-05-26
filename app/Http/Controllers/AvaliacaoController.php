<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Importa o facade Auth para autenticação do usuário
use Illuminate\Support\Facades\Auth;
// Importa os modelos Avaliacao e Disciplina para interagir com o banco de dados
use App\Models\Avaliacao;
// Importa o modelo Disciplina para interagir com as disciplinas
use App\Models\Disciplina;

class AvaliacaoController extends Controller
{

    public function index()
    {
        // Obtém todas as avaliações criadas pelo usuário autenticado
        $avaliacoes = Avaliacao::where('created_by', Auth::id())->with('disciplina')->get();

        // Retorna a view com as avaliações compact é usado para passar variáveis para a view
        return view('avaliacoes.index', compact('avaliacoes'));
    }

    public function create()
    {
        // Obtém todas as disciplinas criadas pelo usuário autenticado para serem usadas no formulário de criação de avaliação
        $disciplinas = Disciplina::where('created_by', Auth::id())->get();
        return view('avaliacoes.create', compact('disciplinas'));
    }

    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário de criação de avaliação
        $data = $request->validate([
            'disciplina_id' => 'required|exists:disciplinas,id',
            'titulo'        => 'required|string|max:255',
            'descricao'     => 'nullable|string',
        ]);

        // Adiciona o ID do usuário autenticado como criador da avaliação
        $data['created_by'] = Auth::id();

        // Cria uma nova avaliação com os dados validados
        // Se não fosse usado o Eloquent, seria necessário fazer uma inserção direta no banco de dados, como:

        // Insert into avaliacoes (disciplina_id, titulo, descricao, created_by) values ($data['disciplina_id'], $data['titulo'], $data['descricao'], Auth::id());
        $avaliacao = Avaliacao::create($data);

        // Redireciona para a página de detalhes da avaliação recém-criada com uma mensagem de sucesso
        return redirect()
            ->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação criada com sucesso!');
    }

    public function show(string $id)
    {
        // Busca a avaliação pelo ID, garantindo que seja do usuário autenticado
        $avaliacao = Avaliacao::where('created_by', Auth::id())->findOrFail($id);
        return view('avaliacoes.show', compact('avaliacao'));
    }

    public function edit(string $id)
    {
        $avaliacao = Avaliacao::where('created_by', Auth::id())->findOrFail($id);

        // Obtém todas as disciplinas criadas pelo usuário autenticado para serem usadas no formulário de edição de avaliação
        // Sem o eloquent, seria necessário fazer uma consulta direta ao banco de dados só com, da seguinte forma:
        // select * from disciplinas where created_by = Auth::id();
        
        $disciplinas = Disciplina::where('created_by', Auth::id())->get();

        return view('avaliacoes.edit', compact('avaliacao', 'disciplinas'));
        // Retorna a view de edição com a avaliação e as disciplinas disponíveis
    }

    public function update(Request $request, string $id)
    {
        $avaliacao = Avaliacao::where('created_by', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'disciplina_id' => 'required|exists:disciplinas,id',
            'titulo'        => 'required|string|max:255',
            'descricao'     => 'nullable|string',
        ]);

        // Atualiza os dados da avaliação com os dados validados
        // Se não fosse usado o Eloquent, seria necessário fazer uma atualização direta no banco de dados, como:
        // Update avaliacoes set disciplina_id = $data['disciplina_id'], titulo = $data['titulo'], descricao = $data['descricao'] where id = $id and created_by = Auth::id();

        $avaliacao->update($data);

        return redirect()
            ->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $avaliacao = Avaliacao::where('created_by', Auth::id())->findOrFail($id);
        
        // Se não fosse usado o Eloquent, seria necessário fazer uma exclusão direta no banco de dados, como:

        // Delete from avaliacoes where id = $id and created_by = Auth::id();
        $avaliacao->delete();

        // Redireciona para a lista de avaliações com uma mensagem de sucesso
        return redirect()
            ->route('avaliacoes.index')
            ->with('success', 'Avaliação excluída com sucesso!');
    }
}
