<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-600 leading-tight">Agendamentos do(a) cliente:
                <strong class="text-purple-700">{{ $client->name }}</strong>
            </span>
            <div class="space-x-2">
                <x-button-link onclick="history.go(-1)">
                    <x-icons.arrow-left class="mr-2"></x-icons.arrow-left>
                    Voltar
                </x-button-link>
                <x-button-link href="{{ route('clients.edit', $client) }}">
                    <x-icons.edit class="mr-2"></x-icons.edit>
                    Editar cliente
                </x-button-link>
                <x-button-link color="purple" href="{{ route('reserves.create', $client) }}">
                    <x-icons.calendar class="mr-2" />
                    Novo agendamento
                </x-button-link>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <!-- FLASH MESSAGES -->
        @if(session('message'))
            <div class="max-w-7xl mx-auto sm😛x-6 lg😛x-8 mb-4">
                <div class="flex bg-purple-600 text-gray-100 shadow-md rounded-md p-4">
                    <x-icons.exclamation-circle class="h-6 w-6 mr-4 "></x-icons.exclamation-circle>
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm😛x-6 lg😛x-8">
            <x-card>
                @if(count($client->reserves))
                    <table class="min-w-full divide-y divide-gray-400">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">Data/hora inicio</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Data/hora final</th>
{{--                            <th class="px-6 py-3 bg-gray-50 text-left">Procedimento</th>--}}
                            <th class="px-6 py-3 bg-gray-50 w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->reserves as $reserve)
                            <tr>
                                <td class="px-6 py-3">{{ $reserve->start_time->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3">{{ $reserve->end_time->format('d/m/Y H:i') }}</td>
{{--                                <td class="px-6 py-3">{{ $reserve->procedure->name }}</td>--}}
                                <td class="flex space-x-4 pt-2 mr-4">
                                    <x-button-link color="green" href="#">
                                        <x-icons.clipboard-check></x-icons.clipboard-check>
                                    </x-button-link>
                                    <x-button-link href="{{ route('reserves.edit', $reserve) }}">
                                        <x-icons.edit></x-icons.edit>
                                    </x-button-link>
                                    <form action="{{ route('reserves.destroy', $reserve) }} " method="post" class="ml-4">
                                        @csrf
                                        @method('delete')
                                        <x-button color="red" class="bg-red-700 hover:bg-red-600">
                                            <x-icons.delete></x-icons.delete>
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6">
                        <h1 class="text-3xl font-bold">Não há agendamentos.</h1>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
