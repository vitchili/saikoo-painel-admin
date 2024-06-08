<?php

namespace App\Filament\Resources\ContatoPessoaClienteResource\Pages;

use App\Filament\Resources\ContatoPessoaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Route;

class CreateContatoPessoaCliente extends CreateRecord
{
    protected static string $resource = ContatoPessoaClienteResource::class;

}
