
<?php

use App\Controllers\AuthController;
use Core\Http\Route;
use App\Controllers\HomeController;
use App\Controllers\LinksController;
use App\Middlewares\AuthMiddleware;


Route::get('/', [HomeController::class, 'index'], AuthMiddleware::class);
Route::get('/signup', [AuthController::class, 'signup'], new AuthMiddleware('guest'));
Route::post('/signup', [AuthController::class, 'doSignup'], new AuthMiddleware('guest'));
Route::get('/login', [AuthController::class, 'login'], new AuthMiddleware('guest'));
Route::post('/login', [AuthController::class, 'doLogin'], new AuthMiddleware('guest'));
Route::get('/logout', [AuthController::class, 'doLogout'], AuthMiddleware::class);

Route::get('/link', [LinksController::class, 'links'], AuthMiddleware::class);
Route::post('/link', [LinksController::class, 'store'], AuthMiddleware::class);
Route::delete('/link/{id}', [LinksController::class, 'delete'], AuthMiddleware::class);

Route::get('/{linkSlug:\w+}', [LinksController::class, 'getUrlBySlug']);
