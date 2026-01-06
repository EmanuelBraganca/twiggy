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
                        <a
                            href="{{ route('links.create') }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm"
                        >
                            Criar Link
                        </a>
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

                                    <!-- Card -->
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $link->name }}</h2>
                                            <span class="text-sm px-2 py-1 rounded-full {{ $link->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }}">
                                                {{ ucfirst($link->status) }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 break-words">{{ $link->url }}</p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="mt-4 flex items-center justify-end">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                                                    ⋮
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link href="{{ route('links.edit', $link) }}">
                                                    Editar
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
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
