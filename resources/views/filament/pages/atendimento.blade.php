<div id="app">
    <x-filament-panels::page style="width: 100%; margin-left: 0px">
        <form wire:submit.prevent="submit">
            {{ $this->form }}
        </form>
        <div class="flex justify-end m-0">
            <div class="fi-ac gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-0">
                <a href="https://hml-paineladmin.taskimob.com.br/admin/chamados/create" style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">
                    <span class="fi-btn-label">
                        Novo chamado
                    </span>
                </a>
                <a href="https://hml-paineladmin.taskimob.com.br/admin/lembretes/create" style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">
                    <span class="fi-btn-label">
                        Criar lembrete
                    </span>
                </a>

            </div>
        </div>
        <App :lembretes="{{ json_encode($lembretes) }}" :chamados="{{ json_encode($chamados) }}" />
    </x-filament-panels::page>
    @vite('resources/js/app.js')
</div>