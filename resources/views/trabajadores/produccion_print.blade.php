<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Producción</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
        }

        @page {
            size: letter landscape;
            margin: 20mm;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        
        /* Ocultar la cabecera y pie de página predeterminados del navegador */
    body {
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact; /* Asegura la precisión en los colores */
    }

    /* Eliminar la URL y otros detalles del navegador */
    body::after {
        content: "";
        display: none;
    }

    @page {
        /* Algunas versiones de navegadores pueden necesitar estos ajustes para ocultar encabezados y pies de página */
        margin: 0;
    }

    .container {
        width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .title {
        text-align: center;
        margin-bottom: 20px;
    }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h2 class="title">Producción del Trabajador</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Número de OT</th>
                    <th>Producto</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($producciones as $produccion)
                    <tr>
                        <td>{{ $produccion->fecha }}</td>
                        <td>{{ $produccion->numero_ot }}</td>
                        <td>{{ $produccion->producto->nombre }}</td>
                        <td>
                            @if($trabajador->cargo == 'Tapicero')
                                {{ number_format($produccion->producto->ctapiceria, 0) }}
                            @elseif($trabajador->cargo == 'Costura')
                                {{ number_format($produccion->producto->ccostura, 0) }}
                            @elseif($trabajador->cargo == 'Cortador')
                                {{ number_format($produccion->producto->ccorte, 0) }}
                            @elseif($trabajador->cargo == 'Armador')
                                {{ number_format($produccion->producto->carmado, 0) }}
                            @elseif($trabajador->cargo == 'Esqueletero')
                                {{ number_format($produccion->producto->ccompleto, 0) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <p><strong>Total de Producción:</strong> {{ number_format($totalProduccion, 0) }}</p>
            <p><strong>Total de Unidades:</strong> {{ $totalUnidades }}</p>
        </div>
    </div>
</body>
</html>
