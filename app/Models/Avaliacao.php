<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model // Declarar a classe Avaliacao - extende Model para herdar funcionalidades do Eloquent ORM
{
    protected $fillable = [ // Atributos que podem ser preenchidos em massa (minimiza a possibilidade de mass assignment vulnerabilities)
        'disciplina_id', 'titulo', 'descricao', 'created_by',
    ];

     // Nome da tabela associada ao modelo, o padrão é pluralizado automaticamente pelo Eloquent, porem nesse caso é definido explicitamente pois o laravel iria adicionar um 's' no final (avaliacaos)
    protected $table = 'avaliacoes';

    // Definindo os relacionamentos com outros modelos
    public function questoes()
    {
        return $this->hasMany(Questao::class); // Uma avaliação pode ter muitas questões
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class); // Uma avaliação pertence a uma disciplina
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'created_by'); // Uma avaliação é criada por um usuário (autor)
    }
}


