<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservar {{ $field->name }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">

        {{-- Info de la cancha --}}
        <div class="bg-white rounded-lg shadow p-5 mb-6">
            <h3 class="font-bold text-lg">{{ $field->name }}</h3>
            <p class="text-gray-500 text-sm">{{ $field->venue->name }} · {{ $field->venue->city }}</p>
            <p class="text-gray-500 text-sm">{{ $field->sportType->icon }} {{ $field->sportType->name }} · {{ ucfirst($field->surface) }}</p>
            <p class="text-green-600 font-semibold mt-2">${{ number_format($field->price_per_hour, 0, ',', '.') }}/hora</p>
        </div>

        {{-- Errores --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulario --}}
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('reservations.store', $field) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" name="date" value="{{ old('date') }}"
                           min="{{ now()->toDateString() }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora inicio</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora fin</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Precio estimado --}}
                <div class="bg-gray-50 rounded p-4 mb-4 text-sm text-gray-600">
                    💡 El precio se calcula automáticamente según las horas seleccionadas.
                    <br>Precio por hora: <strong>${{ number_format($field->price_per_hour, 0, ',', '.') }}</strong>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notas (opcional)</label>
                    <textarea name="notes" rows="3"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Ej: venimos 10 personas, necesitamos petos...">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Confirmar reserva
                    </button>
                    <a href="{{ route('fields.show', $field) }}"
                       class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>