<x-layouts.app>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <h1>{{ $disciplina->nome }}</h1>

        @if ($disciplina->descricao)
            <p>{{ $disciplina->descricao }}</p>
        @endif

        <div class="form-actions">
            <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn yellow">Editar</a>
            <a href="{{ route('disciplinas.index') }}" class="btn gray">Voltar</a>
        </div>
    </div>
</x-layouts.app>
