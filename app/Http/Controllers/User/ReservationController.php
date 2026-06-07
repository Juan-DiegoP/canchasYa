<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Field;
use App\Models\Reservation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $reservations = Reservation::with(['field.venue', 'field.sportType'])
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        return view('user.reservations.index', compact('reservations'));
    }

    public function create(Field $field)
    {
        return view('user.reservations.create', compact('field'));
    }

    public function store(StoreReservationRequest $request, Field $field)
    {
        $overlap = Reservation::where('field_id', $field->id)
            ->whereDate('date', $request->date)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($request) {
                $q->where('start_time', '<', $request->end_time)
                  ->where('end_time', '>', $request->start_time);
            })->exists();

        if ($overlap) {
            return back()->withErrors(['overlap' => 'Ya existe una reserva en ese horario.'])->withInput();
        }

        $start = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $end   = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        $hours = $end->diffInMinutes($start) / 60;
        $total = $hours * $field->price_per_hour;

        Reservation::create([
            'field_id'    => $field->id,
            'user_id'     => Auth::id(),
            'date'        => $request->date,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'total_price' => $total,
            'status'      => 'pending',
            'notes'       => $request->notes,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reserva creada exitosamente.');
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')
            ->with('success', 'Reserva cancelada.');
    }
}