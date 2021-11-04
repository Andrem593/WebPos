<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[HomeController::class,'index'])->name('dashboard');
// RUTAS PRODUCTOS
Route::resource('productos', ProductoController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/upload', [ProductoController::class,'productoUpload'])
->name('productos.upload');

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/saveExcel/', [ProductoController::class,'saveExcel'])
->name('producto.saveExcel');

Route::resource('pedidos', VentaController::class)
->middleware(['auth:sanctum', 'verified']);

// ventas
Route::get('search/productos', [VentaController::class,'autocomplete'])
->name('search.productos')
->middleware(['auth:sanctum', 'verified']);

Route::post('pedido/producto', [VentaController::class,'store'])
->name('pedido.store')
->middleware(['auth:sanctum', 'verified']);

Route::delete('pedido/destroy/{rowId}', [VentaController::class,'destroy'])
->name('pedido.destroy')
->middleware(['auth:sanctum', 'verified']);

Route::get('pedido/destroyAll', [VentaController::class,'destroyAll'])
->name('pedido.destroyAll')
->middleware(['auth:sanctum', 'verified']);

Route::post('pedido/edit/{rowId}', [VentaController::class,'edit'])
->name('pedido.edit')
->middleware(['auth:sanctum', 'verified']);

Route::post('pedido/chekout/{valor}', [VentaController::class,'checkout'])
->name('pedido.chekout')
->middleware(['auth:sanctum', 'verified']);

// RUTAS DE USUARIOS

Route::resource('user', UserController::class)
->names('user')
->middleware(['auth:sanctum', 'verified']);