<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportType;
use Illuminate\Http\Request;

class SportTypeController extends Controller
{
    public function index()
    {
        $sportTypes = SportType::withCount('fields')->orderBy('name')->get();
        return view('admin.sport_types.index', compact('sportTypes'));
    }

    public function create()
    {
        return view('admin.sport_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sport_types,name',
            'icon' => 'nullable|string|max:10',
        ]);

        SportType::create($request->only('name', 'icon'));

        return redirect()->route('admin.sport-types.index')
            ->with('success', 'Tipo de deporte creado.');
    }

    public function edit(SportType $sportType)
    {
        return view('admin.sport_types.edit', compact('sportType'));
    }

    public function update(Request $request, SportType $sportType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sport_types,name,' . $sportType->id,
            'icon' => 'nullable|string|max:10',
        ]);

        $sportType->update($request->only('name', 'icon'));

        return redirect()->route('admin.sport-types.index')
            ->with('success', 'Tipo de deporte actualizado.');
    }

    public function destroy(SportType $sportType)
    {
        $sportType->delete();
        return redirect()->route('admin.sport-types.index')
            ->with('success', 'Tipo de deporte eliminado.');
    }

    public function show(SportType $sportType)
    {
        $sportType->load('fields');
        return view('admin.sport_types.show', compact('sportType'));
    }
}