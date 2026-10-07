<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display buildings and apartments directory.
     */
    public function index()
    {
        $buildings = Building::withCount('apartments')->get();
        $apartments = Apartment::with('building')->paginate(15);

        return view('buildings.index', compact('buildings', 'apartments'));
    }

    /**
     * Store a new building (Admin/Master Admin).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:buildings,code'],
            'total_floors' => ['required', 'integer', 'min:1'],
        ]);

        Building::create($validated);

        return back()->with('success', 'Building added successfully.');
    }

    /**
     * Update existing building block.
     */
    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:buildings,code,' . $building->id],
            'total_floors' => ['required', 'integer', 'min:1'],
        ]);

        $building->update($validated);

        return back()->with('success', "Building '{$building->name}' updated successfully.");
    }

    /**
     * Delete building block.
     */
    public function destroy(Building $building)
    {
        $name = $building->name;
        $building->delete();

        return back()->with('success', "Building '{$name}' deleted successfully.");
    }
}
