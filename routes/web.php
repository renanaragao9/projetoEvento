<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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

Route::get('/',[EventController::class, 'index'])->name('inicio');
Route::get('/verEvento/{id}', [EventController::class, 'show'])->name('verEvento');

Route::middleware(['auth'])->group(function() { 
    Route::get   ('/evento/criar',[EventController::class, 'create'])->name('criarEvento');
    Route::post  ('/Criando', [EventController::class, 'store'])->name('enviarEvento');
    Route::delete('/evento/{id}', [EventController::class, 'destroy'])->name('excluirEvento');
    Route::get   ('/evento/editar/{id}', [EventController::class,'edit'])->name('editarEvento');
    Route::put   ('/evento/atualizar/{id}', [EventController::class, 'update'])->name('atualizarEvento');
    Route::get   ('/dashboard', [EventController::class, 'dashboard'])->name('meuEvento');
    Route::post  ('/evento/unir/{id}', [EventController::class, 'joinEvent'])->name('entrarEvento');
    Route::delete('/evento/sair/{id}', [EventController::class, 'leaveEvent'])->name('deixarEvento');
});
