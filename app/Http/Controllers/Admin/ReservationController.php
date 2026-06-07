<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReservationController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $reservations = Reservation::with(['field.venue', 'field.sportType', 'user'])
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function confirm(Reservation $reservation)
    {
        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Reserva confirmada.');
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);
        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reserva cancelada.');
    }

    public function ocupacion(Request $request)
    {
        $fieldId = $request->field_id;
        $fecha   = $request->fecha ?? now()->toDateString();

        // Semana actual: lunes a domingo
        $startOfWeek = \Carbon\Carbon::parse($fecha)->startOfWeek();
        $endOfWeek   = \Carbon\Carbon::parse($fecha)->endOfWeek();

        $fields = Field::where('active', true)->with('venue')->get();

        $reservations = collect();
        if ($fieldId) {
            $reservations = Reservation::where('field_id', $fieldId)
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->where('status', '!=', 'cancelled')
                ->get();
        }

        return view('admin.reservations.ocupacion', compact(
            'fields', 'reservations', 'fieldId', 'fecha', 'startOfWeek', 'endOfWeek'
        ));
    }
}