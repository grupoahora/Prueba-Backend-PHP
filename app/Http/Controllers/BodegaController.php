<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    public function index()
    {
        $bodegas = Bodega::orderBy('nombre')->get();
        return response()->json($bodegas);
    }

    /**
     * Crear una nueva bodega.
     *
     * Datos de entrada esperados:
     * - nombre (string, requerido): Nombre de la bodega.
     * - id_responsable (integer, opcional): ID del responsable.
     * - estado (string, opcional, valor por defecto 'activo'): Estado de la bodega.
     * - created_by (integer, opcional): ID del usuario que crea la bodega.
     * - updated_by (integer, opcional): ID del usuario que actualiza la bodega.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'id_responsable' => 'nullable|integer',
            'estado' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        // Establecer valor por defecto para estado si no se proporciona
        $validatedData['estado'] = $validatedData['estado'] ?? 'activo';

        // Crear la nueva bodega
        $bodega = Bodega::create($validatedData);

        // Devolver la bodega creada con código 201
        return response()->json($bodega, 201);
    }
}