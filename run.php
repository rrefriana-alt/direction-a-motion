<?php
$c = file_get_contents('routes/web.php');
$c = str_replace("use App\Http\Controllers\Admin\ContentController;", "use App\Http\Controllers\Admin\AuthController;\nuse App\Http\Controllers\Admin\ContentController;", $c);

$authRoutes = "
// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {";

$c = str_replace("// Admin\nRoute::prefix('admin')->name('admin.')->group(function () {", $authRoutes, $c);
file_put_contents('routes/web.php', $c);
