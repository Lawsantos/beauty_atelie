<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-600 leading-tight">Agendamentos do(a) cliente:
                <strong class="text-purple-700">{{ $client->name }}</strong>
            </span>
            <div class="space-x-2">
                <x-button-link class="cursor-pointer" onclick="history.go(-1)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Voltar
                </x-button-link>
                <x-button-link href="{{ route('clients.edit', $client) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Editar
                </x-button-link>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($client->reserves))
                        <table class="min-w-full divide-y divide-gray-400">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">Data/hora inicio</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">Data/hora final</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">Procediemento</th>
                                <th class="px-6 py-3 bg-gray-50 w-1"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($client->reserves as $reserve)
                                <tr>
                                    <td class="px-6 py-3">{{ $reserve->start_time->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-3">{{ $reserve->end_time->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-3">{{ $reserve->procedure->name }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h1>Não há agendamentos.</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
