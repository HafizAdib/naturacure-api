<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RemedeController;
use App\Http\Controllers\Api\AdminController;

use App\Models\User;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// --- Routes Publiques ---
// Utilisateur
// Creer un compte
Route::post('/register', [AuthController::class, 'register']);
// Se connecter
Route::post('/login', [AuthController::class, 'login']);


Route::get('/remedes', [RemedeController::class, 'index']);
Route::get('/remedes/{id}', [RemedeController::class, 'show']);
Route::get('/search-remedes', [RemedeController::class, 'search']);
Route::get('/maladies', function () {
    return \App\Models\Maladie::select('id','nom')->get();
});

// --- Routes Protégées (Middleware Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    // Actions Utilisateur (Likes/Commentaires)
    Route::post('/remedes/{id}/like', [RemedeController::class, 'like']);

    Route::post('/remedes/{id}/comment', [RemedeController::class, 'comment']);
    Route::put('/remedes/{id}/comment', [RemedeController::class, 'edit_comment']);
    Route::delete('/remedes/{id}/comment', [RemedeController::class, 'delete_comment']);


    Route::post('/remedes', [RemedeController::class, 'store']); // Créer un remède + étapes
    Route::put('/remedes/{id}', [RemedeController::class, 'update']);
    Route::delete('/remedes/{id}', [RemedeController::class, 'destroy']);

    // Actions Admin
    Route::middleware('check.role:admin')->group(function () {
        Route::get('/admin/pending', [RemedeController::class, 'pendingRemedes']);
        Route::patch('/remedes/{id}/validate', [RemedeController::class, 'validate']);
        Route::delete('/users/{id}', [AuthController::class, 'destroy']);
    });
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/admin/remedes', [AdminController::class, 'listRemedes']);
    Route::post('/admin/remedes/{id}/approve', [AdminController::class, 'approve']);
    Route::post('/admin/remedes/{id}/reject', [AdminController::class, 'reject']);
    Route::delete('/admin/remedes/{id}', [AdminController::class, 'destroy']);
    Route::post('/admin/maladies', [AdminController::class, 'addMaladie']);
    Route::get('/admin/maladies', [AdminController::class, 'listMaladies']);
});

Route::get('/setup-user', function () {
    return User::create([
        'name' => 'Admin User',
        'email' => 'admin@naturacure.com',
        'password' => Hash::make('password123'),
        'role' => 'admin'
    ]);
});

