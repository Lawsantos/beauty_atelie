<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between items-center">
           <span class="font-semibold text-xl text-gray-800 leading-tight">Agendamentos</span>
       </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <table class="min-w-full divide-y divide-gray-400">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left">Cliente</th>
                        <th class="px-6 py-3 bg-gray-50 text-left">Data/hora incial</th>
                        <th class="px-6 py-3 bg-gray-50 text-left">Data/hora final</th>
                        <th class="px-6 py-3 bg-gray-50 w-1"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reserves as $reserve)
                        <tr>
                            <td class="px-6 py-3">{{ $reserve->client->name }}</td>
                            <td class="px-6 py-3">{{ $reserve->start_time->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3">{{ $reserve->end_time->format('d/m/Y H:i') }}</td>
                            <td class="flex space-x-3 pt-2 mr-4">
                                <x-button-link color="green" href="#">
                                    <x-icons.clipboard-check></x-icons.clipboard-check>
                                </x-button-link>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-6 border-t">
                    {{ $reserves->appends(request()->query())->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
