<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cep',
        'estado_civil',
        'time',
        'profissao',
        'salario',
    ];

    public function historicos()
    {
        return $this->hasMany(CadastroHistorico::class, 'original_id');
    }
}
