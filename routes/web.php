<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    
    // --- DASHBOARD & RECRUITMENT (CRUD UTAMA) ---
    Route::get('/dashboard', [RecruitmentController::class, 'index'])->name('dashboard');
    Route::resource('recruitments', RecruitmentController::class);
    
    // --- FITUR ANGGOTA (JOIN & PIN) ---
    Route::post('/recruitments/{recruitment}/join', [ApplicationController::class, 'store'])
        ->name('recruitments.join');
        
    Route::patch('/applications/{application}/pin', [ApplicationController::class, 'togglePin'])
        ->name('applications.pin'); // Fitur Pin (Legacy, now handled in profile edit)

    Route::get('/joined-teams', [ApplicationController::class, 'joined'])
        ->name('joined-teams');

    // --- FITUR KETUA TIM (KELOLA & UPDATE) ---
    Route::get('/my-teams', [ApplicationController::class, 'index'])
        ->name('my-teams');
        
    Route::patch('/applications/{application}/update-status', [ApplicationController::class, 'updateStatus'])
        ->name('applications.update-status');

    // --- FITUR MANAJEMEN PROJECT (STATUS, FILE, CHAT) ---
    Route::patch('/recruitments/{recruitment}/status', [RecruitmentController::class, 'updateStatus'])
        ->name('recruitments.status'); 

    Route::post('/recruitments/{recruitment}/file', [RecruitmentController::class, 'uploadFile'])
        ->name('recruitments.file');   

    Route::post('/recruitments/{recruitment}/chat', [RecruitmentController::class, 'sendMessage'])
        ->name('recruitments.chat');   

    // --- PROFIL ---
    Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';