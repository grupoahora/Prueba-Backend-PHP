<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function indexTotalDesc()
    {
        $productos = DB::table('productos')
            ->select('productos.id', 'productos.nombre', 'productos.descripcion', 'productos.estado', DB::raw('SUM(inventarios.cantidad) as total'))
            ->leftJoin('inventarios', 'productos.id', '=', 'inventarios.id_producto')
            ->leftJoin('bodegas', 'inventarios.id_bodega', '=', 'bodegas.id')
            ->where('productos.estado', 1)
            ->where('bodegas.estado', 1)
            ->groupBy('productos.id', 'productos.nombre', 'productos.descripcion', 'productos.estado')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($productos);
    }

    public function store(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:300',
            'cantidad_inicial' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $cantidadInicial = $request->input('cantidad_inicial');

        // Usar transacción para asegurar consistencia
        DB::transaction(function () use ($nombre, $descripcion, $cantidadInicial) {
            // Verificar o crear la bodega "Bodega General"
            $bodega = Bodega::firstOrCreate(
                // criterios de búsqueda
                ['nombre' => 'Bodega General'], 
                // valores a usar si no existe
                ['estado' => 1]
            );

            // Crear el producto
            $producto = Producto::create([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'estado' => 1,
            ]);

            // Crear entrada en inventarios
            DB::table('inventarios')->insert([
                'id_bodega' => $bodega->id,
                'id_producto' => $producto->id,
                'cantidad' => $cantidadInicial,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return response()->json(['message' => 'Producto creado exitosamente con inventario inicial.'], 201);
    }
}