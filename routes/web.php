<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    
    // Student routes
    Route::prefix('aluno')->name('aluno.')->group(function () {
        Route::get('/dashboard', [AlunoController::class, 'dashboard'])->name('dashboard');
        Route::get('/boletim', [AlunoController::class, 'boletim'])->name('boletim');
        Route::get('/historico', [AlunoController::class, 'historico'])->name('historico');
        Route::get('/horarios', [AlunoController::class, 'horarios'])->name('horarios');
        Route::get('/matricula-online', [AlunoController::class, 'matriculaOnline'])->name('matricula-online');
        Route::post('/matricula-online', [AlunoController::class, 'realizarMatricula'])->name('realizar-matricula');
    });

    // Professor routes
    Route::prefix('professor')->name('professor.')->group(function () {
        Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('dashboard');
        Route::get('/diario-classe/{turma}', [ProfessorController::class, 'diarioClasse'])->name('diario-classe');
        Route::post('/salvar-notas/{turma}', [ProfessorController::class, 'salvarNotas'])->name('salvar-notas');
        Route::get('/calcular-media-final/{turma}', [ProfessorController::class, 'calcularMediaFinal'])->name('calcular-media-final');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Course management
        Route::get('/cursos', [AdminController::class, 'cursos'])->name('cursos');
        Route::post('/cursos', [AdminController::class, 'storeCurso'])->name('cursos.store');
        Route::put('/cursos/{id}', [AdminController::class, 'updateCurso'])->name('cursos.update');
        Route::delete('/cursos/{id}', [AdminController::class, 'destroyCurso'])->name('cursos.destroy');
        
        // Student management
        Route::get('/alunos', [AdminController::class, 'alunos'])->name('alunos');
        Route::post('/alunos', [AdminController::class, 'storeAluno'])->name('alunos.store');
        
        // Professor management
        Route::get('/professores', [AdminController::class, 'professores'])->name('professores');
        Route::post('/professores', [AdminController::class, 'storeProfessor'])->name('professores.store');
        
        // Reports
        Route::get('/relatorios', [AdminController::class, 'relatorios'])->name('relatorios');
        Route::get('/relatorios/alunos-turma', [AdminController::class, 'relatorioAlunosPorTurma'])->name('relatorio-alunos-turma');
    });
});