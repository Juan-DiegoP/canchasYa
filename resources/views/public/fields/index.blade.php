<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Canchas disponibles
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        {{-- Filtros --}}
        <form method="GET" action="{{ route('fields.index') }}" class="flex gap-4 mb-8 flex-wrap">
            <select name="sport_type_id" class="border rounded px-3 py-2 bg-white text-gray-700">
                <option value="">Todos los deportes</option>
                @foreach($sportTypes as $sport)
                    <option value="{{ $sport->id }}" {{ request('sport_type_id') == $sport->id ? 'selected' : '' }}>
                        {{ $sport->icon }} {{ $sport->name }}
                    </option>
                @endforeach
            </select>

            <select name="city" class="border rounded px-3 py-2 bg-white text-gray-700">
                <option value="">Todas las ciudades</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filtrar
            </button>
            <a href="{{ route('fields.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Limpiar
            </a>
        </form>

        {{-- Listado --}}
        @if($fields->isEmpty())
            <p class="text-gray-400">No hay canchas disponibles con esos filtros.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fields as $field)
                    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                        @if($field->venue->image)
                            <img src="{{ asset('storage/' . $field->venue->image) }}"
                                 alt="{{ $field->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-4xl">
                                {{ $field->sportType->icon ?? '🏟️' }}
                            </div>
                        @endif

                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $field->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $field->venue->name }} · {{ $field->venue->city }}</p>
                            <p class="text-gray-500 text-sm mt-1">{{ $field->sportType->icon }} {{ $field->sportType->name }}</p>
                            <p class="text-green-600 font-semibold mt-2">${{ number_format($field->price_per_hour, 0, ',', '.') }}/hora</p>

                            <a href="{{ route('fields.show', $field) }}"
                               class="mt-auto pt-4 block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>