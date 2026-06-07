<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::withCount('fields')->orderBy('name')->get();
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        return view('admin.venues.create');
    }

    public function store(StoreVenueRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('venues', 'public');
        }

        $data['active'] = $request->boolean('active', true);

        Venue::create($data);

        return redirect()->route('admin.venues.index')
            ->with('success', 'Complejo creado exitosamente.');
    }

    public function edit(Venue $venue)
    {
        return view('admin.venues.edit', compact('venue'));
    }

    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('venues', 'public');
        }

        $data['active'] = $request->boolean('active');

        $venue->update($data);

        return redirect()->route('admin.venues.index')
            ->with('success', 'Complejo actualizado.');
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return redirect()->route('admin.venues.index')
            ->with('success', 'Complejo eliminado.');
    }

    public function show(Venue $venue)
    {
        $venue->load('fields');
        return view('admin.venues.show', compact('venue'));
    }
}