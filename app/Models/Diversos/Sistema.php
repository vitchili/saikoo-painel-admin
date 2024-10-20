<?php

namespace App\Models\Diversos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sistema extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'sistemas';

    protected $fillble = [
        'nome',
    ];
}
