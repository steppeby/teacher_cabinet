<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MaterialController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-db', function () {
    $version = DB::select('SELECT version()');
    return $version;
});

Route::middleware(['auth'])->group(function () {
    // включить для использования Spatie Permission:
    // Route::middleware('role:teacher|methodist|admin')->group(function () {

        Route::resource('materials', MaterialController::class);

        // скачивание конкретного media
        Route::get('/materials/{material}/download/{media}', [MaterialController::class, 'download'])
            ->name('materials.download');

    // });
});

Route::resource('schedules', ScheduleController::class);
Route::get('schedules-export', [ScheduleController::class, 'exportExcel'])->name('schedules.exportExcel');


require __DIR__.'/auth.php';
