<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-center">
                        <h1 class="text-2xl font-bold">Agenda de Hoje</h1>
                    </div>
                    <table class="min-w-full divide-y divide-gray-400">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">Cliente</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Data/hora inicio</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Data/hora final</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Procedimento</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reserves as $reserve)
                            <tr>
                                <td class="px-6 py-3">
                                    <a class="hover:text-purple-600" href="{{ route('clients.show', $reserve->client) }}">
                                        {{ $reserve->client->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-3">{{ $reserve->start_time->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-3">{{ $reserve->end_time->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-3">{{ $reserve->procedure->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="py-4"></div>
                    <div class="flex justify-center">
                        <h1 class="text-2xl font-bold">Agenda de amanhã</h1>
                    </div>
                    <table class="min-w-full divide-y divide-gray-400">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">Cliente</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Data/hora inicio</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Data/hora final</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Procedimento</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tomorrowReserves as $reserve)
                            <tr>
                                <td class="px-6 py-3">
                                    <a class="hover:text-purple-600" href="{{ route('clients.show', $reserve->client) }}">
                                        {{ $reserve->client->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-3">{{ $reserve->start_time->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-3">{{ $reserve->end_time->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-3">{{ $reserve->procedure->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
