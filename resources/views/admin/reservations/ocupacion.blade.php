<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📅 Ocupación semanal</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.reservations.ocupacion') }}" class="flex gap-4 mb-8 flex-wrap items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cancha</label>
                <select name="field_id" class="border rounded px-3 py-2">
                    <option value="">Selecciona una cancha</option>
                    @foreach($fields as $field)
                        <option value="{{ $field->id }}" {{ $fieldId == $field->id ? 'selected' : '' }}>
                            {{ $field->venue->name }} · {{ $field->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semana</label>
                <input type="date" name="fecha" value="{{ $fecha }}"
                       class="border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Ver ocupación
            </button>
        </form>

        @if(!$fieldId)
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-400">
                <p class="text-4xl mb-4">📅</p>
                <p>Selecciona una cancha para ver su ocupación semanal.</p>
            </div>
        @else
            @php
                $hours = range(6, 22); // 6am a 10pm
                $days  = [];
                $current = $startOfWeek->copy();
                while ($current <= $endOfWeek) {
                    $days[] = $current->copy();
                    $current->addDay();
                }
            @endphp

            <div class="bg-white rounded-lg shadow overflow-auto">
                <table class="w-full text-xs text-center">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-3 py-3 text-left text-gray-500 w-16">Hora</th>
                            @foreach($days as $day)
                                <th class="px-2 py-3 font-semibold {{ $day->isToday() ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    {{ $day->isoFormat('ddd') }}<br>
                                    <span class="font-normal text-gray-400">{{ $day->format('d/m') }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($hours as $hour)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-400 text-left font-medium">
                                    {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                </td>
                                @foreach($days as $day)
                                    @php
                                        $slotStart = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                                        $slotEnd   = str_pad($hour + 1, 2, '0', STR_PAD_LEFT) . ':00';

                                        $ocupada = $reservations->first(function ($r) use ($day, $slotStart) {
                                            return $r->date->format('Y-m-d') === $day->format('Y-m-d')
                                                && $r->start_time <= $slotStart
                                                && $r->end_time   >  $slotStart;
                                        });
                                    @endphp
                                    <td class="px-2 py-2 {{ $day->isToday() ? 'bg-blue-50' : '' }}">
                                        @if($ocupada)
                                            <div class="bg-red-400 text-white rounded px-1 py-1 text-xs leading-tight">
                                                🔴<br>
                                                <span class="text-xs">{{ substr($ocupada->start_time, 0, 5) }}-{{ substr($ocupada->end_time, 0, 5) }}</span>
                                            </div>
                                        @else
                                            <div class="bg-green-100 text-green-700 rounded px-1 py-1">
                                                🟢
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Leyenda --}}
            <div class="flex gap-6 mt-4 text-sm text-gray-600">
                <span>🟢 Disponible</span>
                <span>🔴 Reservado</span>
            </div>
        @endif
    </div>
</x-app-layout>