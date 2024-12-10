<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\VentasController;
use App\Models\Clientes;
use App\Models\Empleados;
use App\Models\Medicamento;
use App\Models\Ventas;

Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('laboratorios', LaboratorioController::class);
    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('clientes', ClientesController::class);
    Route::resource('empleados', EmpleadosController::class);
    Route::resource('ventas', VentasController::class);
    Route::get('ventasall', [VentasController::class, 'all']);
    Route::get('ventasbycliente', [VentasController::class, 'VentasByCliente']);
    Route::get('ventasbymedicamento', [VentasController::class, 'VentasByMedicamento']);
    Route::get('medicamentosall', [MedicamentoController::class, 'all']);
    Route::get('medicamentosbylaboratorio', [MedicamentoController::class, 'MedicamentosByLaboratorio']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

});
