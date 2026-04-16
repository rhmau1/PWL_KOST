<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/waiting-approval', function () {
    return view('waiting-approval');
})->name('waiting.approval');

Route::post('/logout-pending', function (\Illuminate\Http\Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/penghuni/login');
})->name('logout.pending');
