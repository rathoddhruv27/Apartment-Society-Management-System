<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Building;
use App\Models\Complaint;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Render the role-appropriate dashboard view.
     */
    public function index()
    {
        $user = Auth::user();
        $roleSlug = $user->role ? $user->role->slug : 'user';

        switch ($roleSlug) {
            case 'master-admin':
                $stats = [
                    'total_users' => User::count(),
                    'total_roles' => Role::count(),
                    'total_permissions' => Permission::count(),
                    'total_buildings' => Building::count(),
                    'total_complaints' => Complaint::count(),
                    'total_visitors' => Visitor::count(),
                ];
                $roles = Role::withCount('users')->get();
                $recentUsers = User::with('role')->latest()->take(5)->get();
                return view('dashboard.master-admin', compact('stats', 'roles', 'recentUsers'));

            case 'admin':
                $stats = [
                    'total_users' => User::count(),
                    'total_buildings' => Building::count(),
                    'total_apartments' => Apartment::count(),
                    'open_complaints' => Complaint::where('status', '!=', 'resolved')->count(),
                    'today_visitors' => Visitor::whereDate('created_at', today())->count(),
                ];
                $recentComplaints = Complaint::with('user')->latest()->take(5)->get();
                $recentVisitors = Visitor::latest()->take(5)->get();
                return view('dashboard.admin', compact('stats', 'recentComplaints', 'recentVisitors'));

            case 'user':
                $stats = [
                    'my_apartments' => $user->apartments()->count(),
                    'my_vehicles' => $user->vehicles()->count(),
                    'my_family' => $user->familyMembers()->count(),
                    'my_complaints' => $user->complaints()->count(),
                    'my_visitors' => $user->visitors()->count(),
                ];
                $myComplaints = $user->complaints()->latest()->take(5)->get();
                $myVisitors = $user->visitors()->latest()->take(5)->get();
                return view('dashboard.user', compact('stats', 'myComplaints', 'myVisitors'));

            case 'security-guard':
                $today = today();
                $stats = [
                    'visitors_today' => Visitor::whereDate('created_at', $today)->count(),
                    'currently_inside' => Visitor::where('status', 'checked_in')->count(),
                    // 'checked_out_today' => Visitor::whereDate('check_out_time', $today)->count(),
                ];
                $activeVisitors = Visitor::where('status', 'checked_in')->latest()->get();
                $recentLogs = Visitor::latest()->take(10)->get();
                return view('dashboard.security-guard', compact('stats', 'activeVisitors', 'recentLogs'));

            default:
                return view('dashboard.user');
        }
    }
}
