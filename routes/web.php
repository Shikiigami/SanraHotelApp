<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('dashboard');



Route::get('/reservations', [App\Http\Controllers\ReservationController::class, 'index'])->name('reservation.index');
Route::get('/get-reservation/data', [App\Http\Controllers\ReservationController::class, 'getReservationData'])->name('reservation.data');
Route::get('/get-guest/{id}', [App\Http\Controllers\ReservationController::class, 'getGuest']);
Route::get('/get-room/{id}', [App\Http\Controllers\ReservationController::class, 'getRoom']);
Route::post('/store/reservation', [App\Http\Controllers\ReservationController::class, 'storeReservation'])->name('store.reservation');
Route::put('/update/reservation/{id}', [App\Http\Controllers\ReservationController::class, 'updateReservation'])->name('update.reservation');
Route::post('/reserve-to-checkin/{id}', [App\Http\Controllers\ReservationController::class, 'reserveTocheckin'])->name('reserve.to.checkin');



Route::get('/rooms', [App\Http\Controllers\RoomController::class, 'roomIndex'])->name('rooms.index');
Route::post('/rooms/store', [App\Http\Controllers\RoomController::class, 'storeRoom'])->name('rooms.store');
Route::put('/rooms/update/{id}', [App\Http\Controllers\RoomController::class, 'updateRoom'])->name('rooms.update');
Route::delete('/rooms/delete/{id}', [App\Http\Controllers\RoomController::class, 'deleteRoom'])->name('rooms.delete');

Route::get('/guests', [App\Http\Controllers\GuestController::class, 'index'])->name('guests.index');
Route::get('/guests/data', [App\Http\Controllers\GuestController::class, 'getGuestsData'])->name('guests.data');
Route::post('/store/guest', [App\Http\Controllers\GuestController::class, 'storeGuest'])->name('store.guest');
Route::put('/update/guest/{id}', [App\Http\Controllers\GuestController::class, 'updateGuest'])->name('update.guest');
Route::delete('/delete/guest/{id}', [App\Http\Controllers\GuestController::class, 'deleteGuest'])->name('delete.guest');

Route::get('/checkins', [App\Http\Controllers\CheckinController::class, 'index'])->name('checkins.index');
Route::get('/get-checkin/data', [App\Http\Controllers\CheckinController::class, 'getCheckinData'])->name('checkin.data');
Route::post('/store/checkin', [App\Http\Controllers\CheckinController::class, 'storeCheckin'])->name('store.checkin');
Route::put('/update/checkin/{id}', [App\Http\Controllers\CheckinController::class, 'updateCheckin'])->name('update.checkin');
Route::post('/add-to-bill/{id}', [App\Http\Controllers\CheckinController::class, 'addToBill'])->name('add.to.billing');

Route::get('billings', [App\Http\Controllers\BillingsController::class, 'index'])->name('billings.index');
Route::get('/get-billings/data', [App\Http\Controllers\BillingsController::class, 'getBillingData'])->name('billings.data');
Route::get('/get-billing-details/{id}', [App\Http\Controllers\BillingsController::class, 'getBillingDetails']);
Route::get('/invoice/{id}', [App\Http\Controllers\BillingsController::class, 'showInvoice'])->name('invoice.show');

Route::post('/billing-details', [App\Http\Controllers\BillingDetailsController::class, 'store'])->name('billing-details.store');
Route::delete('/billing-details/{id}', [App\Http\Controllers\BillingDetailsController::class, 'destroy'])->name('billing-details.destroy');







