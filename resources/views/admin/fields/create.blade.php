<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva cancha</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.fields.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Complejo</label>
                    <select name="venue_id"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona un complejo</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                {{ $venue->name }} · {{ $venue->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deporte</label>
                    <select name="sport_type_id"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona un deporte</option>
                        @foreach($sportTypes as $sport)
                            <option value="{{ $sport->id }}" {{ old('sport_type_id') == $sport->id ? 'selected' : '' }}>
                                {{ $sport->icon }} {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio por hora</label>
                        <input type="number" name="price_per_hour" value="{{ old('price_per_hour') }}"
                               min="0" step="1000"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Capacidad</label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}"
                               min="1"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Superficie</label>
                    <select name="surface"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="synthetic" {{ old('surface') == 'synthetic' ? 'selected' : '' }}>Sintética</option>
                        <option value="grass" {{ old('surface') == 'grass' ? 'selected' : '' }}>Césped natural</option>
                        <option value="cement" {{ old('surface') == 'cement' ? 'selected' : '' }}>Cemento</option>
                    </select>
                </div>

                <div class="mb-6 flex items-center gap-2">
                    <input type="checkbox" name="active" id="active" value="1"
                           {{ old('active', true) ? 'checked' : '' }}>
                    <label for="active" class="text-sm text-gray-700">Activa</label>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Guardar
                    </button>
                    <a href="{{ route('admin.fields.index') }}"
                       class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>