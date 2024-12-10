<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratorioController extends Controller
{
    public function index()
    {
        $laboratorio = Laboratorio::all();
        return response()->json($laboratorio);
    }

    public function store(Request $request)
    {
        $rules = ['laboratorio' => 'required|string|min:1|max:100'];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $laboratorio = new Laboratorio($request->all());
        $laboratorio->save();

        return response()->json([
            'status' => true,
            'message' => 'Laboratorio created successfully'
        ], 201); 
    }

    public function show(Laboratorio $laboratorio)
    {
        return response()->json(['status' => true, 'data' => $laboratorio]);
    }

    public function update(Request $request, Laboratorio $laboratorio)
    {
        $rules = ['laboratorio' => 'required|string|min:1|max:100'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $laboratorio->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Laboratorio updated successfully'
        ], 200);
    }

    public function destroy(Laboratorio $laboratorio)
    {
        $laboratorio->delete();

        return response()->json([
            'status' => true,
            'message' => 'Laboratorio has been deleted successfully'
        ], 200); 
    }
}
