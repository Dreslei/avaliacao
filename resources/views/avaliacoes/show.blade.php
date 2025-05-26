<x-layouts.app>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <h1>Detalhes da Avaliação</h1>

        <div class="card">
            <div class="card-section">
                <h2>Título:</h2>
                <p>{{ $avaliacao->titulo }}</p>
            </div>

            <div class="card-section">
                <h2>Disciplina:</h2>
                <p>{{ $avaliacao->disciplina->nome ?? '-' }}</p>
            </div>

            <div class="card-section">
                <h2>Descrição:</h2>
                <p>{{ $avaliacao->descricao ?? '---' }}</p>
            </div>

            <div class="form-actions">
                <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="btn yellow">Editar</a>
                <a href="{{ route('avaliacoes.index') }}" class="btn gray">Voltar</a>
            </div>
        </div>
    </div>
</x-layouts.app>
