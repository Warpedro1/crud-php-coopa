<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroHistorico extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_id',
        'nome',
        'email',
        'telefone',
        'cep',
        'estado_civil',
        'time',
        'profissao',
        'salario',
    ];


    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class, 'original_id');
    }
}
