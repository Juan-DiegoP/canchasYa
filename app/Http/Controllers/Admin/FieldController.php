<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Field;
use App\Models\SportType;
use App\Models\Venue;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with(['venue', 'sportType'])->orderBy('name')->get();
        return view('admin.fields.index', compact('fields'));
    }

    public function create()
    {
        $venues     = Venue::where('active', true)->orderBy('name')->get();
        $sportTypes = SportType::orderBy('name')->get();
        return view('admin.fields.create', compact('venues', 'sportTypes'));
    }

    public function store(StoreFieldRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active', true);

        Field::create($data);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Cancha creada exitosamente.');
    }

    public function edit(Field $field)
    {
        $venues     = Venue::where('active', true)->orderBy('name')->get();
        $sportTypes = SportType::orderBy('name')->get();
        return view('admin.fields.edit', compact('field', 'venues', 'sportTypes'));
    }

    public function update(UpdateFieldRequest $request, Field $field)
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active');

        $field->update($data);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Cancha actualizada.');
    }

    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('admin.fields.index')
            ->with('success', 'Cancha eliminada.');
    }

    public function show(Field $field)
    {
        $field->load(['venue', 'sportType', 'reservations']);
        return view('admin.fields.show', compact('field'));
    }
}