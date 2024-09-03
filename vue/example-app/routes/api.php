<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventFptiController;
use App\Http\Controllers\EventPengeluaranController;
use App\Http\Controllers\EventTransaksiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/create-event-fpti',[EventFptiController::class,'createEvent_Anyar']);
Route::put('/update-event-fpti/{id}',[EventFptiController::class,'updateEvent_Anyar']);
Route::get('/edit-event-fpti/{id}',[EventFptiController::class,'editEvent_Anyar']);
Route::get('/show-event-fpti/{id}',[EventFptiController::class,'showEvent_Anyar']);
Route::get('/show-semua-event-fpti',[EventFptiController::class,'indexEvent_Anyar']);
Route::delete('/delete-event-fpti/{id}', [EventFptiController::class, 'deleteEvent_Anyar']);

Route::post('/create-transaksi-fpti',[EventTransaksiController::class,'createEvent_Transaksi']);
Route::put('/update-event-transaksi/{id}', [EventTransaksiController::class, 'updateEvent_Transaksi']);
Route::get('/edit-event-transaksi/{id}',[EventFptiController::class,'editEvent_Transaksi']);
Route::get('/show-transaksi/{event_id}',[EventTransaksiController::class,'showEvent_Transaksi']);
Route::get('/show-semua-transaksi-fpti',[EventTransaksiController::class,'indexEvent_Transaksi']);
Route::delete('/delete-event-transaksi/{id}',[EventTransaksiController::class,'deleteEvent_Transaksi']);

Route::post('/create-pengeluaran-fpti',[EventPengeluaranController::class,'createEvent_Pengeluaran']);
Route::put('/update-event-pengeluaran/{id}', [EventPengeluaranController::class, 'updateEvent_Pengeluaran']);
Route::get('/edit-event-pengeluaran/{id}',[EventPengeluaranController::class,'editEvent_Pengeluaran']);
Route::get('/show-pengeluaran/{event_id}',[EventPengeluaranController::class,'showEvent_Pengeluaran']);
Route::get('/show-semua-pengeluaran-fpti',[EventPengeluaranController::class,'indexEvent_Pengeluaran']);
Route::delete('/delete-event-pengeluaran/{id}',[EventPengeluaranController::class,'deleteEvent_Pengeluaran']);

Route::get('/show-total-saldo',[DashboardController::class,'getTotalSaldo']);
Route::get('/show-event-for-dashboard',[DashboardController::class,'getEventsForDashboard']);
Route::get('/show-dua-transaksi',[DashboardController::class,'indexDua']);
Route::get('/show-semua-transaksi',[DashboardController::class,'index']);