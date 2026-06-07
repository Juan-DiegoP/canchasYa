<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis reservas
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        @if($reservations->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                <p class="text-4xl mb-4">📅</p>
                <p>No tienes reservas aún.</p>
                <a href="{{ route('fields.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Ver canchas disponibles
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-lg shadow p-5 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-lg">{{ $reservation->field->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $reservation->field->venue->name }} · {{ $reservation->field->venue->city }}</p>
                            <p class="text-gray-600 text-sm mt-1">
                                📅 {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                · ⏰ {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}
                            </p>
                            <p class="text-green-600 font-semibold mt-1">
                                ${{ number_format($reservation->total_price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex flex-col items-end gap-3">
                            {{-- Badge de estado --}}
                            @php
                                $badge = match($reservation->status) {
                                    'pending'   => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                };
                                $label = match($reservation->status) {
                                    'pending'   => 'Pendiente',
                                    'confirmed' => 'Confirmada',
                                    'cancelled' => 'Cancelada',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badge }}">
                                {{ $label }}
                            </span>

                            {{-- Botón cancelar --}}
                            @if($reservation->status === 'pending')
                                <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                                      onsubmit="return confirm('¿Cancelar esta reserva?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-sm text-red-600 hover:underline">
                                        Cancelar reserva
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>