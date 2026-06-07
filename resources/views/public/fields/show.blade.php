<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $field->name }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow overflow-hidden">

            {{-- Imagen --}}
            @if($field->venue->image)
                <img src="{{ asset('storage/' . $field->venue->image) }}"
                     alt="{{ $field->name }}"
                     class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-6xl">
                    {{ $field->sportType->icon ?? '🏟️' }}
                </div>
            @endif

            <div class="p-6">
                {{-- Info principal --}}
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $field->name }}</h1>
                        <p class="text-gray-500">{{ $field->venue->name }} · {{ $field->venue->city }}</p>
                    </div>
                    <span class="text-2xl font-bold text-green-600">
                        ${{ number_format($field->price_per_hour, 0, ',', '.') }}/hora
                    </span>
                </div>

                {{-- Detalles --}}
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-600">
                    <div>🏅 Deporte: <span class="font-medium">{{ $field->sportType->icon }} {{ $field->sportType->name }}</span></div>
                    <div>🌿 Superficie: <span class="font-medium">{{ ucfirst($field->surface) }}</span></div>
                    @if($field->capacity)
                        <div>👥 Capacidad: <span class="font-medium">{{ $field->capacity }} personas</span></div>
                    @endif
                    <div>📍 Dirección: <span class="font-medium">{{ $field->venue->address }}</span></div>
                    @if($field->venue->phone)
                        <div>📞 Teléfono: <span class="font-medium">{{ $field->venue->phone }}</span></div>
                    @endif
                </div>

                {{-- Descripción --}}
                @if($field->description)
                    <p class="text-gray-600 mb-6">{{ $field->description }}</p>
                @endif

                {{-- Botón reservar --}}
                @auth
                    <a href="{{ route('reservations.create', $field) }}"
                       class="block text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Reservar esta cancha
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="block text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Inicia sesión para reservar
                    </a>
                @endauth
            </div>
        </div>

        <a href="{{ route('fields.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">
            ← Volver al listado
        </a>
    </div>
</x-app-layout>