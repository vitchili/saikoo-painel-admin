<?php

namespace App\Observers;

use App\Gateway\Bitpag\ClienteBitPag;
use App\Models\Cliente\Cliente;
use App\Models\User;
use App\Services\NotificacaoExceptionGeralService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClienteObserver
{
    /**
     * Handle the Cliente "creating" event.
     */
    public function creating(Cliente $cliente): void
    {
    }

    /**
     * Handle the Cliente "created" event.
     */
    public function created(Cliente $cliente): void
    {
        
    }

    /**
     * Handle the Cliente "updating" event.
     */
    public function updating(Cliente $cliente): void
    {
        $tornarClienteOriginal = $cliente->getOriginal('tornar_cliente');
        
        if ($tornarClienteOriginal == 'S'  && $cliente->tornar_cliente == 'N') {
            $cliente->tornar_cliente = 'S';
            new NotificacaoExceptionGeralService('Impossível retirar a marcação de "Tornar Cliente" do cliente.');
        }

        if ($tornarClienteOriginal == 'N' && $cliente->tornar_cliente == 'S') {
            $ultimoCliente = Cliente::whereNotNull('codigo')->orderBy('codigo', 'desc')->first();
            $cliente->codigo = ! empty($ultimoCliente->codigo) ? ($ultimoCliente->codigo + 1) : 1;
            $cliente->codico = ! empty($ultimoCliente->codigo) ? ($ultimoCliente->codigo + 1) : 1;
            $cliente->senha = Str::password(15);

            $user = User::create([
                'name' => $cliente->nome,
                'email' => $cliente->email ?? $cliente->email_resp,
                'password' => Hash::make($cliente->senha),
                'phone' => $cliente->telefone ?? $cliente->fone_resp1 ?? null,
                'color_hash' => '#CCCCCC',
                'avatar_url' => null,
                'cliente_id' => $cliente->id,
            ]);

            $user->assignRole('Cliente');
        }
    }

    /**
     * Handle the Cliente "deleted" event.
     */
    public function updated(Cliente $cliente): void
    {
        $bitpagIdOriginal = $cliente->getOriginal('cliente_bitpag_id');

        if ($cliente->tornar_cliente == 'S' && empty($bitpagIdOriginal)) {
            $bitPagCliente = new ClienteBitPag();
            $bitPagCliente->cadastrarCliente($cliente);
        }
    }

    /**
     * Handle the Cliente "restored" event.
     */
    public function restored(Cliente $cliente): void
    {
        //
    }

    /**
     * Handle the Cliente "force deleted" event.
     */
    public function forceDeleted(Cliente $cliente): void
    {
        //
    }
}
