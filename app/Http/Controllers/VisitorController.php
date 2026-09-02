<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    /**
     * Display visitor logs.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('user')) {
            $visitors = Visitor::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $visitors = Visitor::with('user')->latest()->paginate(10);
        }

        return view('visitors.index', compact('visitors'));
    }

    /**
     * Store new visitor / pre-approved pass.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'vehicle_number' => ['nullable', 'string', 'max:50'],
            'purpose' => ['required', 'string', 'max:255'],
            'visit_date' => ['nullable', 'date'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Visitor::create($validated);

        return back()->with('success', 'Visitor pass created successfully.');
    }

    /**
     * Update visitor status (Check-in / Check-out by Security Guard or Admin).
     */
    public function updateStatus(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:expected,pending,approved,checked_in,checked_out,rejected,denied'],
        ]);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'checked_in') {
            $updateData['check_in_time'] = now();
        } elseif ($validated['status'] === 'checked_out') {
            $updateData['check_out_time'] = now();
        }

        $visitor->update($updateData);

        return back()->with('success', "Visitor status updated to {$validated['status']}.");
    }
}
