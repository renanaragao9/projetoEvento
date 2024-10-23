<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;

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

Route::get('/',                   [EventController::class, 'index'])->name('inicio');
Route::get('/verEvento/{id}',     [EventController::class, 'show'])->name('verEvento');

Route::middleware(['auth'])->group(function() { 
    Route::get   ('/evento/criar',          [EventController::class, 'create'])->name('criarEvento');
    Route::post  ('/Criando',               [EventController::class, 'store'])->name('enviarEvento');
    Route::delete('/evento/{id}',           [EventController::class, 'destroy'])->name('excluirEvento');
    Route::get   ('/evento/editar/{id}',    [EventController::class, 'edit'])->name('editarEvento');
    Route::put   ('/evento/atualizar/{id}', [EventController::class, 'update'])->name('atualizarEvento');
    Route::get   ('/dashboard',             [EventController::class, 'dashboard'])->name('meuEvento');
    Route::post  ('/evento/unir/{id}',      [EventController::class, 'joinEvent'])->name('entrarEvento');
    Route::delete('/evento/sair/{id}',      [EventController::class, 'leaveEvent'])->name('deixarEvento');
    Route::get   ('/evento/informacao/{id}',[EventController::class, 'infoEvent'])->name('informacaoEvento');

    Route::get('/events/{id}/pending-requests',         [EventController::class, 'showPendingRequests'])->name('events.pendingRequests');
    Route::post('/events/{eventId}/approve/{userId}',   [EventController::class, 'approveRequest'])->name('events.approveRequest');
    Route::post('events/{eventId}/approveAllRequests',  [EventController::class, 'approveAllRequests'])->name('events.approveAllRequests');
    Route::post('/events/{eventId}/reject/{userId}',    [EventController::class, 'rejectRequest'])->name('events.rejectRequest');

    Route::post('/events/{event}/galleries',                 [GalleryController::class, 'store'])->name('galleries.store');
    Route::delete('/gallery/images/{id}',                    [GalleryController::class, 'destroy'])->name('images.destroy');
    Route::delete('/gallery/event/delete-all/{eventFolder}', [GalleryController::class, 'deleteAll'])->name('images.deleteAll');
});
