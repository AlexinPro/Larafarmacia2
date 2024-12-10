<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();
        return response()->json($clientes);
    }

    /*public function create()
    {
        //
    }*/

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|min:1|max:100',
            'apellidos' => 'required|string|min:1|max:100',
            'direccion' => 'required|string|min:1|max:100'
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errrors' => $validator->errors()->all()
            ], 400);
        }
        $clientes = new Clientes($request->all());
        $clientes->save();
        return response()->json([
            'status' => true,
            'message' => 'Client has been created successfully'
        ], 201); 
    }

    public function show(Clientes $clientes, $id)
    {
        $cliente = Clientes::find($id);
        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $cliente
        ]);
    }

    /*public function edit(Clientes $clientes)
    {
        //
    }*/

    public function update(Request $request, Clientes $clientes, $id)
    {
        $clientes = Clientes::find($id);
        $rules = [
            'nombre' => 'required|string|min:1|max:100',
            'apellidos' => 'required|string|min:1|max:100',
            'direccion' => 'required|string|min:1|max:100'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $clientes->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'client has been updated succesfully'
        ],200);
    }

    public function destroy(Clientes $clientes, $id)
    {
        $clientes = Clientes::find($id);
        $clientes->delete();
        return response()->json([
            'status' => true,
            'message' => 'client has been deleted successfully'
        ], 200); 
    }
}
