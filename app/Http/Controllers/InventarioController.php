<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Inventario;
use App\Models\Historiale;

class InventarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  int  $request->id_producto ID del producto (requerido, entero)
     * @param  int  $request->id_bodega ID de la bodega (requerido, entero)
     * @param  int  $request->cantidad Cantidad a agregar (requerido, entero, mínimo 1)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer',
            'id_bodega' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);

        $inventario = Inventario::where('id_producto', $request->id_producto)
            ->where('id_bodega', $request->id_bodega)
            ->first();

        if ($inventario) {
            $inventario->cantidad += $request->cantidad;
            $inventario->updated_by = auth()->id();
            $inventario->save();
        } else {
            $inventarionuevo = Inventario::create([
                'id_producto' => $request->id_producto,
                'id_bodega' => $request->id_bodega,
                'cantidad' => $request->cantidad,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

        }

        // Registrar en historial
        Historiale::create([
            'cantidad' => $request->cantidad,
            'id_bodega_destino' => $request->id_bodega,
            'id_inventario' => $inventario->id ?? $inventarionuevo->id,
            'created_by' => auth()->id(), // O el ID del usuario autenticado si aplica
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Inventario actualizado correctamente']);
    }

    /**
     * Transfer inventory between warehouses.
     * @param  Request  $request
     * @param int $request->id_producto ID del producto
     * @param int $request->id_bodega_origen ID de la bodega origen
     * @param int $request->id_bodega_destino ID de la bodega destino
     * @param int $request->cantidad cantidad a transferir
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request)
    {
        Log::info('Inicio de transfer: ' . json_encode($request->all()));

        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|integer',
            'id_bodega_origen' => 'required|integer',
            'id_bodega_destino' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            Log::warning('Validación fallida: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Log::info('Validación pasada. Origen: ' . $request->id_bodega_origen . ', Destino: ' . $request->id_bodega_destino);

        // Validar que bodega_origen != bodega_destino
        if ($request->id_bodega_origen == $request->id_bodega_destino) {
            Log::warning('Bodegas iguales detectadas');
            return response()->json(['error' => 'La bodega de origen y destino deben ser diferentes'], 422);
        }

        // Validar existencia de inventarios para origen y destino con el producto
        $inventarioOrigen = Inventario::where('id_producto', $request->id_producto)
            ->where('id_bodega', $request->id_bodega_origen)
            ->first();

        $inventarioDestino = Inventario::where('id_producto', $request->id_producto)
            ->where('id_bodega', $request->id_bodega_destino)
            ->first();

        if (!$inventarioOrigen) {
            Log::warning('Inventario origen no encontrado para producto: ' . $request->id_producto . ', bodega: ' . $request->id_bodega_origen);
            return response()->json(['error' => 'No existe inventario para el producto en la bodega de origen'], 404);
        }

        if (!$inventarioDestino) {
            Log::warning('Inventario destino no encontrado para producto: ' . $request->id_producto . ', bodega: ' . $request->id_bodega_destino);
            return response()->json(['error' => 'No existe inventario para el producto en la bodega de destino'], 404);
        }

        Log::info('Inventarios encontrados. Origen cantidad: ' . $inventarioOrigen->cantidad . ', Destino cantidad: ' . $inventarioDestino->cantidad);

        // Validar que la cantidad en origen sea suficiente
        if ($inventarioOrigen->cantidad < $request->cantidad) {
            Log::warning('Cantidad insuficiente. Origen: ' . $inventarioOrigen->cantidad . ', Solicitado: ' . $request->cantidad);
            return response()->json(['error' => 'Cantidad insuficiente en la bodega de origen'], 422);
        }

        // Restar la cantidad del inventario origen
        $inventarioOrigen->cantidad -= $request->cantidad;
        $inventarioOrigen->updated_by = auth()->id();
        $inventarioOrigen->save();

        // Sumar la cantidad al inventario destino
        $inventarioDestino->cantidad += $request->cantidad;
        $inventarioDestino->updated_by = auth()->id();
        $inventarioDestino->save();

        Log::info('Inventarios actualizados. Origen nueva cantidad: ' . $inventarioOrigen->cantidad . ', Destino nueva cantidad: ' . $inventarioDestino->cantidad);

        // Insertar registro en Historiales
        $historialorigen = Historiale::create([
            'cantidad' => $request->cantidad,
            'id_bodega_origen' => $request->id_bodega_origen,
            'id_bodega_destino' => $request->id_bodega_destino,
            'id_inventario' => $inventarioOrigen->id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
        $historialdestino = Historiale::create([
            'cantidad' => $request->cantidad,
            'id_bodega_origen' => $request->id_bodega_origen,
            'id_bodega_destino' => $request->id_bodega_destino,
            'id_inventario' => $inventarioDestino->id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        Log::info('Historial insertado con ID: ' . $historialorigen->id);
        Log::info('Historial insertado con ID: ' . $historialdestino->id);

        return response()->json(['message' => 'Traslado realizado correctamente']);
    }
}