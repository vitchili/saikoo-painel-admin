<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representante extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'mostrarNoSite',
        'nome',
        'cpf',
        'cep',
        'logradouro',
        'complemento',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'telefone',
        'telefoneSecundario',
        'email',
    ];
}
