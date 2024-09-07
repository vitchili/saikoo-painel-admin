<?php

namespace App\Services;

use Filament\Notifications\Notification;

class NotificacaoExceptionGeralService
{
    public function __construct(string $mensagemErro, ?string $titulo = 'Erro')
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
                        <h2 style='margin: 0; font-weight: 700;'>". $titulo ."</h2>
                        <p style='margin: 5px 0 0 0;'>" . $mensagemErro . "</p>
                    </div>
                </div>
                ")
                ->danger()
                ->send();
    }
}
