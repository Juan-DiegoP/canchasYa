<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Complejos deportivos</h2>
            <a href="{{ route('admin.venues.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo complejo
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Ciudad</th>
                        <th class="px-4 py-3 text-left">Teléfono</th>
                        <th class="px-4 py-3 text-center">Canchas</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($venues as $venue)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $venue->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $venue->city }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $venue->phone ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $venue->fields_count }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($venue->active)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.venues.edit', $venue) }}"
                                   class="text-blue-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.venues.destroy', $venue) }}"
                                      class="inline" onsubmit="return confirm('¿Eliminar este complejo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">No hay complejos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>