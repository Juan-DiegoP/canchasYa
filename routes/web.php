<?php

use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\SportTypeController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Public\FieldController;
use App\Http\Controllers\User\ReservationController;
use Illuminate\Support\Facades\Route;

// ── Zona pública ──────────────────────────────────────────────
Route::get('/', [FieldController::class, 'index'])->name('home');
Route::get('/canchas', [FieldController::class, 'index'])->name('fields.index');
Route::get('/canchas/{field}', [FieldController::class, 'show'])->name('fields.show');

// ── Perfil (Breeze) ───────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Auth (Breeze) ─────────────────────────────────────────────
require __DIR__.'/auth.php';

// ── Zona usuario autenticado ──────────────────────────────────
Route::middleware(['auth'])->prefix('mis-reservas')->name('reservations.')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('index');
    Route::get('/crear/{field}', [ReservationController::class, 'create'])->name('create');
    Route::post('/crear/{field}', [ReservationController::class, 'store'])->name('store');
    Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('destroy');
});

// ── Zona admin ────────────────────────────────────────────────
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Venues
    Route::resource('venues', VenueController::class);

    // Canchas
    Route::resource('fields', AdminFieldController::class);

    // Tipos de deporte
    Route::resource('sport-types', SportTypeController::class);

    // Reservas
    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::patch('reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::patch('reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('reservations/ocupacion', [AdminReservationController::class, 'ocupacion'])->name('reservations.ocupacion');
});