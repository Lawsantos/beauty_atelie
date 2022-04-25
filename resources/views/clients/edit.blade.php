<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-600 leading-tight">Atualizar cliente:
                <strong class="text-purple-700">{{ $client->name }}</strong>
            </span>
            <div class="space-x-2">
                <x-button-link class="cursor-pointer" onclick="history.go(-1)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Voltar
                </x-button-link>
                <x-button-link color="purple" href="{{ route('reserves.create', $client) }}">
                    <x-icons.calendar class="mr-2" />
                    Novo agendamento
                </x-button-link>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('clients.update', $client) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-label for="name" :value="__('Nome')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? $client->name" required autofocus />
                        </div>
                        <div>
                            <x-label for="phone" :value="__('Telefone')" />

                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone') ?? $client->phone" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-button type="submit">Atualizar</x-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
