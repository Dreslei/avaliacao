<x-layouts.app>
    <head>
        {{-- Importando o CSS do Laravel (Pasta Public) --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <h1>Editar Avaliação</h1>

        <form action="{{ route('avaliacoes.update', $avaliacao) }}" method="POST">
            @csrf

            {{-- Método PUT para indicar que estamos atualizando um recurso existente, html nao tem metodo put por padrao, por isso utilizamos no form o POST --}}
            @method('PUT')

            <div class="form-group">
                <label for="disciplina_id">Disciplina</label>
                <select name="disciplina_id" id="disciplina_id" required>
                    @foreach($disciplinas as $disciplina)
                        <option value="{{ $disciplina->id }}" {{ $avaliacao->disciplina_id == $disciplina->id ? 'selected' : '' }}>
                            {{ $disciplina->nome }}
                        </option>
                    @endforeach
                </select>
                @error('disciplina_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $avaliacao->titulo) }}" required>
                @error('titulo') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" rows="4">{{ old('descricao', $avaliacao->descricao) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit">Atualizar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
