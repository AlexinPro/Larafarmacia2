<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamento = Medicamento::select('medicamentos.*', 'laboratorios.laboratorio as laboratorio')
            ->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')
            ->paginate(10);
        return response()->json($medicamento);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:100',
            'caducidad' => 'required|date',
            'precio' => 'required|numeric',
            'laboratorio_id' => 'required|numeric',
            'image' => 'nullable|image|mimes:png,jpg|max:5120' // Validación de imagen
        ];
        $messages = [
            'image.formato' => 'por favor selecciona un formato PNG o JPG.',
            'image.max' => 'El tamaño máximo permitido para la imagen es de 5MB.',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        // Procesar imagen
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('medicamentos', 'public'); // Guardar imagen
        }

        $medicamento = new Medicamento($request->except('image'));
        $medicamento->image = $path;
        $medicamento->save();

        return response()->json([
            'status' => true,
            'message' => 'Medicament created successfully'
        ], 200);
    }

    public function show(Medicamento $medicamento)
    {
        return response()->json(['status' => true, 'data' => $medicamento]);
    }

    public function showImage($id)
    {
        $medicamento = Medicamento::find($id);
        if ($medicamento && $medicamento->image) {
            $url = Storage::url($medicamento->image); // Obtener URL de la imagen
            return response()->json(['status' => true, 'image_url' => asset($url)]);
        }
        return response()->json(['status' => false, 'message' => 'Image not found'], 404);
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:100',
            'caducidad' => 'required|date|max:30',
            'precio' => 'required|numeric|between:0,99999.99',
            'laboratorio_id' => 'required|numeric',
            'image' => 'nullable|image|mimes:png,jpg|max:5120'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        if ($request->hasFile('image')) {
            if ($medicamento->image) {
                Storage::delete('public/' . $medicamento->image); 
            }
            $path = $request->file('image')->store('medicamentos', 'public');
            $medicamento->image = $path;
        }

        $medicamento->fill($request->except('image'));
        $medicamento->save();
        return response()->json([
            'status' => true,
            'message' => 'Medicament has been updated successfully'
        ], 200);
    }

    public function destroy(Medicamento $medicamento)
    {
        if ($medicamento->image) {
            Storage::delete('public/' . $medicamento->image);
        }

        $medicamento->delete();

        return response()->json([
            'status' => true,
            'message' => 'Medicament has been deleted successfully'
        ], 200);
    }

    public function MedicamentosByLaboratorio()
    {
        $medicamento = Medicamento::selectRaw('count(medicamentos.id) as count, laboratorios.laboratorio')
            ->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')
            ->groupBy('laboratorios.laboratorio')
            ->get();
        return response()->json($medicamento);
    }

    public function all()
    {
        $medicamento = Medicamento::select('medicamentos.*', 'laboratorios.laboratorio as laboratorio')
            ->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')
            ->get();
        return response()->json($medicamento);
    }
}