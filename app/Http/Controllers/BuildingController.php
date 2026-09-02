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
            'code' => ['required', 'string', 'max:50', 'unique:buildings'],
            'total_floors' => ['required', 'integer', 'min:1'],
        ]);

        Building::create($validated);

        return back()->with('success', 'Building added successfully.');
    }
}
