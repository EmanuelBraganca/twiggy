<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-md flex items-center justify-center font-bold"></div>
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Meus Links</h1>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input
                            type="search"
                            placeholder="Pesquisar..."
                            class="px-3 py-2 border rounded-md text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        />
                        <button
                            type="button"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                            {{ route('links.create-links') }}
                        >
                            Criar Link
                        </button>
                    </div>
                </div>

                <div class="p-4">
                    @php $links = App\Models\Link::orderBy('position')->get(); @endphp

                    @if($links->isEmpty())
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                            Nenhum link encontrado. Clique em "Criar Link" para adicionar o primeiro.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($links as $link)
                                <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $link->name }}</h2>
                                            <span class="text-sm px-2 py-1 rounded-full {{ $link->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }}">
                                                {{ ucfirst($link->status) }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 break-words">{{ $link->url }}</p>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Posição: <span class="font-medium text-gray-700 dark:text-gray-200">{{ $link->position }}</span></div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ $link->url }}" target="_blank" class="text-sm px-3 py-1 bg-white dark:bg-gray-800 border rounded text-indigo-600 hover:bg-indigo-50">Abrir</a>
                                            <a href="#" class="text-sm px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Editar</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
