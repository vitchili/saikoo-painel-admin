<?php

namespace App\Models;

use App\Models\Chamado\Chamado;
use App\Models\Lembrete\Lembrete;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'color_hash',
        'avatar_url',
        'cliente_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function lembretes(): BelongsToMany
    {
        return $this->belongsToMany(Lembrete::class, 'lembretes_tecnicos', 'tecnico_id', 'lembrete_id');
    }

    public function chamados()
    {
        return $this->belongsToMany(Chamado::class, 'chamados_tecnicos', 'tecnico_id', 'chamado_id');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $originalPath = asset($this->avatar_url);
        $originalPath = str_replace('/fotos_perfis', '/storage/fotos_perfis', $originalPath);

        if (empty($this->avatar_url)) {
            return null;
        }
        return $originalPath;
    }
}
