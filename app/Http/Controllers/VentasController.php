<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentasController extends Controller
{
    // Método para obtener ventas paginadas con información del cliente y del medicamento
    public function index()
    {
        $ventas = Ventas::select(
            'ventas.*',
            'clientes.nombre as cliente', // Alias para el nombre del cliente
            'medicamentos.name as medicamento' // Alias para el nombre del medicamento
        )
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id') // Unión con la tabla clientes
        ->join('medicamentos', 'medicamentos.id', '=', 'ventas.medicamento_id') // Unión con la tabla medicamentos
        ->paginate(10); // Paginación

        return response()->json($ventas);
    }

    // Método para almacenar una nueva venta
    public function store(Request $request)
    {
        $rules = [
            'cliente_id' => 'required|numeric',
            'medicamento_id' => 'required|numeric',
            'cantidad' => 'required|integer|min:1|max:1000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $ventas = new Ventas($request->all());
        $ventas->save();

        return response()->json([
            'status' => true,
            'message' => 'Venta created successfully'
        ], 200);
    }

    // Método para mostrar una venta específica
    public function show($id)
    {
        $ventas = Ventas::select(
            'ventas.*',
            'clientes.nombre as cliente',
            'medicamentos.name as medicamento'
        )
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('medicamentos', 'medicamentos.id', '=', 'ventas.medicamento_id')
        ->where('ventas.id', $id)
        ->first();

        if (!$ventas) {
            return response()->json([
                'status' => false,
                'message' => 'Venta not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $ventas
        ]);
    }

    // Método para actualizar una venta existente
    public function update(Request $request, $id)
    {
        $ventas = Ventas::find($id);

        if (!$ventas) {
            return response()->json([
                'status' => false,
                'message' => 'Venta not found'
            ], 404);
        }

        $rules = [
            'cliente_id' => 'required|numeric',
            'medicamento_id' => 'required|numeric',
            'cantidad' => 'required|integer|min:1|max:1000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $ventas->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Venta has been updated successfully'
        ], 200);
    }

    // Método para eliminar una venta
    public function destroy($id)
    {
        $ventas = Ventas::find($id);

        if (!$ventas) {
            return response()->json([
                'status' => false,
                'message' => 'Venta not found'
            ], 404);
        }

        $ventas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Venta has been deleted successfully'
        ], 200);
    }

    // Método para obtener estadísticas por cliente
    public function VentasByCliente()
    {
        $ventas = Ventas::selectRaw('count(ventas.id) as count, clientes.nombre')
            ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
            ->groupBy('clientes.nombre')
            ->get();

        return response()->json($ventas);
    }

    // Método para obtener estadísticas por medicamento
    public function VentasByMedicamento()
    {
        $ventas = Ventas::selectRaw('count(ventas.id) as count, medicamentos.name')
            ->join('medicamentos', 'medicamentos.id', '=', 'ventas.medicamento_id')
            ->groupBy('medicamentos.name')
            ->get();

        return response()->json($ventas);
    }

    // Método para obtener todas las ventas sin paginación
    public function all()
    {
        $ventas = Ventas::select(
            'ventas.*',
            'clientes.nombre as cliente',
            'medicamentos.name as medicamento'
        )
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('medicamentos', 'medicamentos.id', '=', 'ventas.medicamento_id')
        ->get();

        return response()->json($ventas);
    }
}
