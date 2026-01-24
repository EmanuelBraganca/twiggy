<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 text-white rounded-lg flex items-center justify-center font-bold">L</div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Meus Links</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Organize e compartilhe seus links favoritos</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <input
                            type="search"
                            placeholder="Pesquisar..."
                            class="px-3 py-2 border rounded-md text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <a
                            href="{{ route('links.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm shadow-sm"
                        >
                            Criar Link
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($links->isEmpty())
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                            Nenhum link encontrado. Clique em "Criar Link" para adicionar o primeiro.
                        </div>
                    @else
                        <div id="links-list" class="flex flex-col items-center gap-6 mt-4">
                            @foreach($links as $link)
                                <div
                                    class="link-card relative w-full max-w-3xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 flex items-center hover:shadow-lg transform hover:-translate-y-1 transition"
                                    data-id="{{ $link->id }}"
                                >
                                    <button
                                        type="button"
                                        class="drag-handle mr-4 cursor-grab active:cursor-grabbing text-gray-400 hover:text-gray-200 select-none"
                                        aria-label="Arrastar para reordenar"
                                        title="Arrastar"
                                    >
                                        ⠿
                                    </button>

                                    <div class="flex-1 text-center">
                                        <a
                                            href="{{ $link->url }}"
                                            target="_blank"
                                            class="text-xl md:text-2xl font-extrabold text-gray-900 dark:text-gray-100 hover:underline"
                                        >
                                            {{ $link->name }}
                                        </a>

                                        <div class="mt-3 flex items-center justify-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="text-xs {{ $link->status ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $link->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex-none ml-4">
                                        <x-dropdown align="center" width="48" class="relative z-50">
                                            <x-slot name="trigger">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-gray-500 hover:text-gray-700 transition"
                                                    aria-label="Abrir menu"
                                                >
                                                    <span class="text-xl leading-none">⋮</span>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link
                                                    href="{{ route('links.edit', $link) }}"
                                                    class="flex justify-center"
                                                >
                                                    Editar
                                                </x-dropdown-link>

                                                <form method="POST" action="{{ route('links.destroy', $link) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <x-dropdown-link
                                                        href="#"
                                                        class="flex justify-center text-red-500"
                                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                                    >
                                                        Remover
                                                    </x-dropdown-link>
                                                </form>
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

    {{-- SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('links-list');
            if (!el) return;

            const meta = document.querySelector('meta[name="csrf-token"]');
            const csrf = meta ? meta.getAttribute('content') : null;

            new Sortable(el, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'opacity-40',
                onEnd: async () => {
                    const items = [...el.querySelectorAll('.link-card')];

                    const payload = items.map((node, index) => ({
                        id: Number(node.dataset.id),
                        position: (index + 1) * 10, // espaçado pra facilitar inserts futuros
                    }));

                    try {
                        const res = await fetch("{{ route('links.reorder') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
                            },
                            body: JSON.stringify({ order: payload })
                        });

                        if (!res.ok) {
                            console.error('Falha ao salvar ordem:', await res.text());
                        }
                    } catch (e) {
                        console.error('Erro ao salvar ordem:', e);
                    }
                }
            });
        });
    </script>
</x-app-layout>
