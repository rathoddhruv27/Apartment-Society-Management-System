<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display complaints list.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('user')) {
            $complaints = Complaint::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $complaints = Complaint::with(['user', 'assignedTo'])->latest()->paginate(10);
        }

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Store new complaint.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';

        Complaint::create($validated);

        return back()->with('success', 'Complaint submitted successfully.');
    }

    /**
     * Update complaint status/assignment (Admin / Master Admin).
     */
    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved,closed'],
            'priority' => ['sometimes', 'in:low,medium,high,urgent'],
            'admin_remarks' => ['nullable', 'string'],
        ]);

        $complaint->update($validated);

        return back()->with('success', 'Complaint status updated.');
    }
}
