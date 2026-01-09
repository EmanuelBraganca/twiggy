<div>
	<x-app-layout>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900 dark:text-gray-100">
					<!-- Formulário para editar um link -->
					<form method="POST" action="{{ route('links.update', $link) }}">
						@csrf
						@method('PATCH')

						<div class="mb-4">
							<label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome do Link</label>
							<input type="text" name="name" id="name" required value="{{ old('name', $link->name) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
						</div>

						<div class="mb-4">
							<label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL do Link</label>
							<input type="url" name="url" id="url" required value="{{ old('url', $link->url) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
						</div>

						<div class="flex items-center justify-end mt-4">
							<a href="{{ route('index') }}" class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
								{{ __('Cancel') }}
							</a>
							<button type="submit" class="inline-flex items-center px-6 py-2 ml-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
								{{ __('Update Link') }}
							</button>
						</div>
					</form>
				</div>
	</x-app-layout>
</div>
