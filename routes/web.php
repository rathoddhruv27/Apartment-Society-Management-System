<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch-role');

    // Role-aware Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Admin Only: Roles & Permissions Matrix
    Route::middleware('role:master-admin')->group(function () {
        Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
        Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('roles.permissions.update');
    });

    // Admin & Master Admin: User Management & Society Config
    Route::middleware('role:master-admin,admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
        Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
    });

    // Visitor Desk (Security Guard, Admin, Master Admin & Resident Invites)
    Route::middleware('permission:view-visitors,view-own-visitors')->group(function () {
        Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
        Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    });

    Route::middleware('permission:checkin-visitors,manage-visitors')->group(function () {
        Route::put('/visitors/{visitor}/status', [VisitorController::class, 'updateStatus'])->name('visitors.status.update');
    });

    // Complaints Module
    Route::middleware('permission:view-complaints,view-own-complaints')->group(function () {
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    });

    Route::middleware('permission:manage-complaints')->group(function () {
        Route::put('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    });
});
