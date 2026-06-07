<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todas las reservas</h2>
            <a href="{{ route('admin.reservations.ocupacion') }}"
               class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                📅 Ver ocupación
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Cancha</th>
                        <th class="px-4 py-3 text-left">Complejo</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Horario</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $reservation->user->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $reservation->user->email }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $reservation->field->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $reservation->field->venue->name }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</td>
                            <td class="px-4 py-3 text-right font-medium text-green-600">
                                ${{ number_format($reservation->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
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
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                @if($reservation->status === 'pending')
                                    <form method="POST" action="{{ route('admin.reservations.confirm', $reservation) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:underline">Confirmar</button>
                                    </form>
                                @endif
                                @if($reservation->status !== 'cancelled')
                                    <form method="POST" action="{{ route('admin.reservations.cancel', $reservation) }}"
                                          class="inline" onsubmit="return confirm('¿Cancelar esta reserva?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-600 hover:underline">Cancelar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-400">No hay reservas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>