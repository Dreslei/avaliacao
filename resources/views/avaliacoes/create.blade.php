<x-layouts.app>
    <head>
        {{-- Importando o CSS do Laravel (Pasta Public) --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <h1>Criar Avaliação</h1>

        <form action="{{ route('avaliacoes.store') }}" method="POST">
            @csrf
            {{-- Token CSRF para segurança, é necessário para evitar ataques de falsificação de requisição entre sites --}}

            <div class="form-group">
                <label for="disciplina_id">Disciplina</label>
                <select name="disciplina_id" id="disciplina_id" required>
                    <option value="">Selecione...</option>
                    @foreach($disciplinas as $disciplina)
                        {{-- Value é o ID (PK) da disciplina, olde é usado para manter a disciplina que o usuario selecionou, caso ocorra algum erro de validação   --}}
                        <option value="{{ $disciplina->id }}" {{ old('disciplina_id') == $disciplina->id ? 'selected' : '' }}>  {{-- IF ternario, onde está verificando se o que foi inserido pelo usuario é igual ao ID existente, então marca selecionado  --}}
                            {{ $disciplina->nome }}
                        </option>
                    @endforeach
                </select>
                {{-- Exibe mensagem de erro caso a validação de algum problema --}}
                @error('disciplina_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required>
                @error('titulo') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" rows="4">{{ old('descricao') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
