<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between items-center">
           <span class="font-semibold text-xl text-gray-800 leading-tight">Clientes</span>
           <x-button-link color="purple" href=" {{ route('clients.create') }}">
               <x-icons.plus class="mr-2"></x-icons.plus>
               Novo cliente
           </x-button-link>
       </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <table class="min-w-full divide-y divide-gray-400 mb-4">
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
                            <td class="px-6 py-3">
                                <a class="hover:text-purple-600" href="{{ route('clients.edit', $client) }}">
                                    {{ $client->name }}
                                </a>
                            </td>
                            <td class="px-6 py-3">{{ $client->phone }}</td>
                            <td class="flex space-x-3 pt-2 mr-4">
                                @if($client->reserves_count > 0)
                                    <x-button-link color="purple" href="{{ route('clients.show', $client) }}">
                                        <x-icons.clock></x-icons.clock>
                                    </x-button-link>
                                @else
                                    <x-button-disabled>
                                        <x-icons.clock></x-icons.clock>
                                    </x-button-disabled>
                                @endif
                                <form action="{{ route('clients.destroy', $client) }} " method="post" class="ml-4">
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
                <div class="px-4 py-6 border-t border">
                    {{ $clients->appends(request()->query())->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
