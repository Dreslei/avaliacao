<x-layouts.app>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <div class="header">
            <h1>Avaliações</h1>
            <a href="{{ route('avaliacoes.create') }}" class="btn">Nova Avaliação</a>
        </div>

        {{-- session('success') = Verifica se existe uma mensagem de sucesso na sessão, se existir, exibe a mensagem --}}
        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Disciplina</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- forelse = Ele também é usado para percorrer, muito parecido com o foreach ele apenas simplifica o uso do if e else juntos, ja tratando com o empty caso não encontre nenhuma informação  --}}
                @forelse ($avaliacoes as $avaliacao) 
                    <tr>
                        <td>{{ $avaliacao->titulo }}</td>
                        <td>{{ $avaliacao->disciplina->nome ?? '-' }}</td>  {{-- IF Ternario, se encontrar o nome na da disciplina na tabela avaliacao entao vai mostrar Senão vai trazer apenas "-"  --}}
                        <td>
                            <a href="{{ route('avaliacoes.show', $avaliacao) }}" class="link blue">Ver</a> {{-- Para acessar a rota Show, é necessario passar o ID da avaliação --}}
                            <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="link yellow">Editar</a> {{-- Para acessar a rota Edit, é necessario passar o ID da avaliação --}}
                            <form action="{{ route('avaliacoes.destroy', $avaliacao) }}" method="POST" class="inline"> {{-- Para acessar a rota destroy, é necessario passar o ID da avaliação --}}
                                @csrf
                                @method('DELETE')
                                <button class="link red" onclick="return confirm('Deseja excluir esta avaliação?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhuma avaliação cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
