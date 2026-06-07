<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tipos de deporte</h2>
            <a href="{{ route('admin.sport-types.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo deporte
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Icono</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-center">Canchas</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sportTypes as $sport)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-2xl">{{ $sport->icon }}</td>
                            <td class="px-4 py-3 font-medium">{{ $sport->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $sport->fields_count }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.sport-types.edit', $sport) }}"
                                   class="text-blue-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.sport-types.destroy', $sport) }}"
                                      class="inline" onsubmit="return confirm('¿Eliminar este deporte?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">No hay deportes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>