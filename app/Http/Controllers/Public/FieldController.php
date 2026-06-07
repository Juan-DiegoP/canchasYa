<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\SportType;
use App\Models\Venue;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $query = Field::with(['venue', 'sportType'])
            ->where('active', true);

        if ($request->filled('sport_type_id')) {
            $query->where('sport_type_id', $request->sport_type_id);
        }

        if ($request->filled('city')) {
            $query->whereHas('venue', fn($q) => $q->where('city', $request->city));
        }

        $fields = $query->get();
        $sportTypes = SportType::all();
        $cities = Venue::where('active', true)->distinct()->pluck('city');

        return view('public.fields.index', compact('fields', 'sportTypes', 'cities'));
    }

    public function show(Field $field)
    {
        $field->load(['venue', 'sportType']);
        return view('public.fields.show', compact('field'));
    }
}