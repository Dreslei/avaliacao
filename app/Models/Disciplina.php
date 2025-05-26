<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $table = 'disciplinas';

// Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'created_by',
    ];
}
