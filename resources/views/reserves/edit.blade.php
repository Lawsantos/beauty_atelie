<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                Atualizar agendamento para: <strong>{{ $reserve->client->name }}</strong>
            </span>
            <x-button-link class="cursor-pointer" onclick="history.go(-1)">
                <x-icons.arrow-left class="mr-2"></x-icons.arrow-left>
                Voltar
            </x-button-link>
        </div>
    </x-slot>
    <div class="py-12">
        <!-- FLASH MESSAGES -->
        @if(session('message'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="flex bg-purple-600 text-gray-100 shadow-md rounded-md p-4">
                    <x-icons.exclamation-circle class="h-6 w-6 mr-4 "></x-icons.exclamation-circle>
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('reserves.update', $reserve) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-label for="name" :value="__('Procedimento')" />
                            <x-select id="procedure_id" name="procedure_id">
                                @foreach($procedures as $procedure)
                                    <option @if($reserve->procedure_id == $procedure->id)selected @endif
                                    value="{{ old('procedure_id') ?? $procedure->id }}">{{ $procedure->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <x-label for="name" :value="__('Data')" />
                            <x-input id="name" class="block mt-1 w-full" type="date" name="date" :value="old('date') ?? $reserve->start_time->format('Y-m-d')" required autofocus />
                        </div>
                        <div class="flex space-x-4 items-center">
                            <div>
                                <x-label for="start_time" class="whitespace-nowrap" :value="__('Hora inicio')" />
                                <x-input id="start_time" class="block mt-1 w-full" type="text" name="start_time"
                                         :value="old('start_time') ?? $reserve->start_time->format('h:i')" required autofocus />

                            </div>
                            <div>
                                <x-label for="end_time" class="whitespace-nowrap" :value="__('Hora fim')" />
                                <x-input id="end_time" class="block mt-1 w-full" type="text" name="end_time"
                                         :value="old('end_time') ?? $reserve->end_time->format('h:i')" required autofocus />
                            </div>
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
