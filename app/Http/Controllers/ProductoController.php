<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\Historiale;
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

    /**
     * Store a new product with initial inventory.
     *
     * This method creates a new product and assigns an initial quantity to the "Bodega General".
     * It validates the input data, creates the product, updates the inventory, and logs the operation in the history.
     *
     * @param Request $request The HTTP request containing the product information.
     *                       - nombre (required, string, max:50): The name of the product.
     *                       - descripcion (required, string, max:300): The description of the product.
     *                       - cantidad_inicial (required, integer, min:0): The initial quantity to add to the inventory.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or validation errors.
     */
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
            $inventarioId = DB::table('inventarios')->insertGetId([
                'id_bodega' => $bodega->id,
                'id_producto' => $producto->id,
                'cantidad' => $cantidadInicial,
                
            ]);

            // Registrar en historial
            Historiale::create([
                'cantidad' => $cantidadInicial,
                'id_bodega_destino' => $bodega->id,
                'id_inventario' => $inventarioId,
                'created_by' => auth()->user()->id, // O el ID del usuario autenticado si aplica
                'updated_by' => auth()->user()->id,
            ]);
        });

        return response()->json(['message' => 'Producto creado exitosamente con inventario inicial.'], 201);
    }
}