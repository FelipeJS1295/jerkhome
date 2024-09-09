<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\OrdenDeCompra;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Producto;

class ExcelImportController extends Controller
{
    public function showImportForm()
    {
        return view('ordenes_de_compra.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls',
        ]);

        $errores = [];

        try {
            $file = $request->file('archivo')->getRealPath();
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $data = [];

            if (isset($rows[0][0]) && $rows[0][0] === 'Número de orden de compra') {
                $data = $this->procesarArchivoNuevoCliente($rows, $errores);
            } elseif (isset($rows[0][0]) && $rows[0][0] === 'Order Item Id') { // Criterio para Falabella
                $data = $this->procesarArchivoFalabella($rows, $errores);
            } else {
                $data = $this->procesarArchivoClienteExistente($rows, $errores);
            }

            if (!empty($errores)) {
                return redirect()->route('excel.import.form')->withErrors($errores);
            }

            return view('ordenes_de_compra.preview', compact('data'));

        } catch (\Exception $e) {
            $errores[] = 'Error al procesar el archivo: ' . $e->getMessage();
            return redirect()->route('excel.import.form')->withErrors($errores);
        }
    }

    private function procesarArchivoFalabella($rows, &$errores)
    {
        $data = [];
        $clienteId = 3; // ID del cliente Falabella Retail S.A.

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Saltar la fila de encabezado
            }

            $cliente = Cliente::find($clienteId);
            $producto = Producto::where('sku', $row[1])->first();

            $ordenExistente = OrdenDeCompra::where('orden_de_compra', $row[4])->first();
            $esRepetida = $ordenExistente ? true : false;

            if (!$producto) {
                $errores[] = "Producto no encontrado en la fila " . ($index + 1) . ": SKU " . $row[1];
                continue;
            }

            try {
                $data[] = [
                    'fecha' => $this->validateAndParseDate($row[3], $index, 'fecha de compra', $errores),
                    'orden_de_compra' => $row[4],
                    'cliente' => $cliente ? $cliente->nombre : 'Cliente desconocido',
                    'producto' => $producto->nombre,
                    'monto' => $this->cleanMonto($row[36]),
                    'fecha_envio' => $this->validateAndParseDate($row[50], $index, 'fecha de envío', $errores),
                    'es_repetida' => $esRepetida,
                    'rut' => $row[11] ?? null,
                    'nombre_cliente_final' => $row[9] ?? null,
                    'estado_orden' => 'nuevo',
                ];
            } catch (\Exception $e) {
                $errores[] = "Error en la fila " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        return $data;
    }

    private function procesarArchivoClienteExistente($rows, &$errores)
    {
        $data = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Saltar la fila de encabezado
            }

            $clienteId = ($row[1] === 'N/A') ? 1 : $row[2];
            $cliente = Cliente::find($clienteId);

            $sku = $this->cleanSku($row[17]);
            $producto = Producto::where('sku', $sku)->first();

            $ordenExistente = OrdenDeCompra::where('orden_de_compra', $row[0])->first();
            $esRepetida = $ordenExistente ? true : false;

            if (!$producto) {
                $errores[] = "Producto no encontrado en la fila " . ($index + 1) . ": SKU " . $row[17];
                continue;
            }

            try {
                $data[] = [
                    'fecha' => Carbon::parse($row[6])->format('d-m-Y'),
                    'orden_de_compra' => $row[0],
                    'cliente' => $cliente ? $cliente->nombre : 'Cliente desconocido',
                    'producto' => $producto->nombre,
                    'monto' => $row[11],
                    'fecha_envio' => Carbon::parse($row[7])->format('d-m-Y'),
                    'es_repetida' => $esRepetida,
                    'rut' => $row[3] ?? null,
                    'nombre_cliente_final' => $row[2] ?? null,
                    'estado_orden' => 'nuevo',
                ];
            } catch (\Exception $e) {
                $errores[] = "Error en la fila " . ($index + 1) . ": " . $e->getMessage();
            }
        }
        return $data;
    }

    private function procesarArchivoNuevoCliente($rows, &$errores)
    {
        $data = [];
        $clienteId = 2; // ID del nuevo cliente
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Saltar la fila de encabezado
            }

            $cliente = Cliente::find($clienteId);
            $producto = Producto::where('sku', $row[24])->first();

            $ordenExistente = OrdenDeCompra::where('orden_de_compra', $row[1])->first();
            $esRepetida = $ordenExistente ? true : false;

            if (!$producto) {
                $errores[] = "Producto no encontrado en la fila " . ($index + 1) . ": SKU " . $row[24];
                continue;
            }

            try {
                $data[] = [
                    'fecha' => Carbon::parse($row[2])->format('d-m-Y'),
                    'orden_de_compra' => $row[1],
                    'cliente' => $cliente ? $cliente->nombre : 'Cliente desconocido',
                    'producto' => $producto->nombre,
                    'monto' => $row[25],
                    'fecha_envio' => Carbon::parse($row[3])->format('d-m-Y'),
                    'es_repetida' => $esRepetida,
                    'rut' => $row[7] ?? null,
                    'nombre_cliente_final' => $row[5] ?? null,
                    'estado_orden' => 'nuevo',
                ];
            } catch (\Exception $e) {
                $errores[] = "Error en la fila " . ($index + 1) . ": " . $e->getMessage();
            }
        }
        return $data;
    }

    // Almacena los datos importados en la base de datos
    public function store(Request $request)
    {
        $data = $request->input('data');

        foreach ($data as $row) {
            $cliente = Cliente::where('nombre', $row['cliente'])->first();
            $producto = Producto::where('nombre', $row['producto'])->first();

            // Si no se encuentra el cliente o producto, redirigir con error
            if (!$cliente || !$producto) {
                return redirect()->route('excel.import.form')->withErrors(['Error al guardar la orden de compra.']);
            }

            // Verificar si las claves 'rut' y 'nombre_cliente_final' existen en $row
            $rut = isset($row['rut']) ? $row['rut'] : null;
            $nombre_cliente_final = isset($row['nombre_cliente_final']) ? $row['nombre_cliente_final'] : null;

            // Crear orden de compra
            OrdenDeCompra::create([
                'fecha' => $this->parseDate($row['fecha']),
                'orden_de_compra' => $row['orden_de_compra'],
                'cliente_id' => $cliente->id,
                'producto_id' => $producto->id,
                'monto' => $row['monto'],
                'fecha_envio' => $this->parseDate($row['fecha_envio']),
                'rut' => isset($row['rut']) ? $row['rut'] : null,
                'nombre_cliente_final' => isset($row['nombre_cliente_final']) ? $row['nombre_cliente_final'] : null,
                'estado_orden' => isset($row['estado_orden']) ? $row['estado_orden'] : 'nuevo',
                'unidades' => 1, // Asignar el valor por defecto de 1
            ]);
        }

        // Redirigir a la lista de órdenes de compra con mensaje de éxito
        return redirect()->route('ordenes-de-compra.index')->with('success', 'Órdenes de compra cargadas exitosamente.');
    }

    // Convierte la fecha de Excel a un formato adecuado
    private function parseDate($value)
    {
        if (is_numeric($value)) {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    // Limpia el SKU del producto eliminando el sufijo '-1'
    private function cleanSku($sku)
    {
        return preg_replace('/-1$/', '', $sku);
    }

    private function validateAndParseDate($dateString, $rowIndex, $fieldName, &$errores)
    {
        try {
            return Carbon::parse($dateString)->format('d-m-Y');
        } catch (\Exception $e) {
            $errores[] = "Error en la fila $rowIndex: No se pudo parsear la $fieldName: $dateString. " . $e->getMessage();
            return null;
        }
    }

    // Limpia el monto eliminando caracteres no numéricos
    private function cleanMonto($monto)
    {
        // Eliminar cualquier carácter que no sea un dígito o un punto decimal
        return preg_replace('/[^\d.]/', '', $monto);
    }
}
