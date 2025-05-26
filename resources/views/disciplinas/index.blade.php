<x-layouts.app :title="__('Minhas Disciplinas')">
    <head>
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <div class="header">
            <h1>Minhas Disciplinas</h1>
            <a href="{{ route('disciplinas.create') }}" class="btn">+ Nova Disciplina</a>
        </div>

        @if ($disciplinas->isEmpty())
            <p>Nenhuma disciplina cadastrada.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($disciplinas as $disciplina)
                        <tr>
                            <td>{{ $disciplina->nome }}</td>
                            <td title="{{ $disciplina->descricao }}">
                                {{ Str::limit($disciplina->descricao, 80) }}
                            </td>
                            <td>
                                <a href="{{ route('disciplinas.show', $disciplina) }}" class="link blue">Ver</a>
                                <a href="{{ route('disciplinas.edit', $disciplina) }}" class="link yellow">Editar</a>
                                <form action="{{ route('disciplinas.destroy', $disciplina) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="button"
                                        class="btn-excluir link red"
                                        data-nome="{{ $disciplina->nome }}">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layouts.app>
