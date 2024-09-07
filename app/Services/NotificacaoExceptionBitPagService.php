<?php

namespace App\Services;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotificacaoExceptionBitPagService
{
    public function __construct($mensagemErro)
    {
        Notification::make()
            ->title("
                <div style='
                    display: flex;
                    align-items: center;
                    background-color: #ffe5e5;
                    color: #b22222;
                    border: 1px solid #b22222;
                    padding: 15px;
                    border-radius: 8px;
                '>
                    <div>
                        <h2 style='margin: 0; font-weight: 700;'>Erro na integração com BitPag</h2>
                        <p style='margin: 5px 0 0 0;'>" . $mensagemErro . "</p>
                    </div>
                </div>
                ")
                ->danger()
                ->send();
    }
}
