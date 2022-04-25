<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between items-center">
           <span class="font-semibold text-xl text-gray-800 leading-tight">Clientes</span>
           <x-button-link href=" {{ route('clients.create') }}">
               Novo cliente
           </x-button-link>
       </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-400">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left">Telefone</th>
                            <th class="px-6 py-3 bg-gray-50 w-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td class="px-6 py-3">{{ $client->name }}</td>
                                    <td class="px-6 py-3">{{ $client->phone }}</td>
                                    <td class="flex space-x-3 pt-2">
                                        @if($client->reserves_count > 0)
                                            <x-button-link class="bg-purple-700 hover:bg-purple-600" href="{{ route('clients.show', $client) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </x-button-link>
                                        @else
                                            <x-button-disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </x-button-disabled>
                                        @endif
                                        <x-button-link href="{{ route('clients.edit', $client) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </x-button-link>
                                        <form action="{{ route('clients.destroy', $client) }} " method="post" class="ml-4">
                                            @csrf
                                            @method('delete')
                                            <x-button class="bg-red-700 hover:bg-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $clients->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
