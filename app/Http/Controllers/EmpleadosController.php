<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadosController extends Controller
{
    public function index()
    {
        $empleados = Empleados::all();
        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|min:1|max:100',
            'apellidos' => 'required|string|min:1|max:100',
            'correo' => 'required|string|min:1|max:30'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errrors' => $validator->errors()->all()
            ], 400);
        }
        $empleados = new Empleados($request->all());
        $empleados->save();
        return response()->json([
            'status' => true,
            'message' => 'Empleado has been created successfully'
        ], 201); 
    }

    public function show($id)
    {
        $empleados = Empleados::find($id);//este va en update, delete y get(para id)

        if(!$empleados){
            return response()->json([
                'status' => false,
                'data' => $empleados
            ],404);
        }
        return response()->json([
            'status' => true,
            'data' => $empleados
        ]);
    }

    public function update(Request $request, Empleados $empleados,$id)
    {
        $empleados = Empleados::find($id);
        $rules = [
            'nombre' => 'required|string|min:1|max:100',
            'apellidos' => 'required|string|min:1|max:100',
            'correo' => 'required|string|email|max:100|unique:empleados'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $empleados->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'empleado has been updated succesfully'
        ],200);
    }

    public function destroy(Empleados $empleados, $id)
    {
        $empleados = Empleados::find($id);
        $empleados->delete();
        return response()->json([
            'status' => true,
            'message' => 'empelado has been deleted succesfully'            
        ],200);
    }
}
