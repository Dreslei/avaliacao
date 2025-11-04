<x-layouts.app>
     <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <h1>Nova Disciplina</h1>

        <form action="{{ route('disciplinas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nome">Nome da Disciplina</label>
                <input
                    type="text"
                    name="nome"
                    id="nome"
                    value="{{ old('nome') }}"
                    placeholder="Ex: Introdução à Programação"
                >
                @error('nome')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea
                    name="descricao"
                    id="descricao"
                    rows="4"
                    placeholder="Descreva brevemente o conteúdo da disciplina"
                >{{ old('descricao') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit">Criar Disciplina</button>
            </div>
        </form>
    </div>
</x-layouts.app>
