<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">Novo cliente</span>
        </div>
    </x-slot>
    <div class="py-12">
        <!-- FLASH MESSAGES -->
        @if(session('message'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="flex bg-green-600 text-gray-100 shadow-md rounded-md p-4">
                    <x-icons.exclamation-circle class="h-6 w-6 mr-4 "></x-icons.exclamation-circle>
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
                    @csrf
                        <div>
                            <x-label for="name" :value="__('Nome')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                        <div>
                            <x-label for="phone" :value="__('Telefone')" />

                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-button type="submit">Salvar</x-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
