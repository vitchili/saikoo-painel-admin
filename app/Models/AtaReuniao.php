<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtaReuniao extends Model
{
    use HasFactory;

    protected $table = 'ata_reunioes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'titulo',
        'texto',
        'anexo',
        'criado_por',
    ];

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public static function boot() {
        parent::boot();
    
        static::creating(function (AtaReuniao $item) {
            $item->criado_por = auth()->user()->id;
        });
    }
}
