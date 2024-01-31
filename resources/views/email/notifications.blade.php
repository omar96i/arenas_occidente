<!DOCTYPE html>
<html>

<head>
    <title>¡Notificaciones de pendientes!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border-radius: 15px;
            border: solid 1px #0077ff;
        }

        h1,
        h2 {
            color: #333;
        }

        p {
            color: #666;
        }

        /* Estilos para las tablas */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        /* Estilos para las filas de la tabla */
        .table-light,
        .table-light>th,
        .table-light>td {
            background-color: #f8f9fa;
        }

        /* Estilos para las tablas responsivas */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }

        /* Estilos específicos para las tablas de encabezado oscuro */
        .table-primary {
            color: #000000;
            background-color: #6180a3;
        }

        /* Estilos para las filas de tabla en el hover */
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>


    <div class="container">
        <div style="text-align: center">
            <img src="https://arenas.occidente.lflsoftware.com/icono.png" alt="">
        </div>

        <h1 style="color: #526983;">¡Notificación de Pendientes!</h1>

        <p>Aquí tienes la información acerca de los registros, actividades o documentos que están próximos a vencer o que están a punto de culminar su periodo de cumplimiento. Esta notificación tiene como objetivo alertarte sobre la inminente fecha de vencimiento o conclusión de ciertos elementos</p>

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr class="text-center">
                        <th colspan="4" scope="col">Lista de Control de Inspecciones pasados y proximos</th>
                    </tr>
                    <tr>
                        <th scope="col">Equipo/Maquinaria</th>
                        <th scope="col">Ultima inspección</th>
                        <th scope="col">Proxima inspección</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inspections as $inspection)
                        <tr class="table-light">
                            <td scope="row">{{ $inspection->equipment_machinery->name }}</td>
                            <td>{{ $inspection->last_report }}</td>
                            <td>{{ $inspection->next_report }}</td>
                            <td>{{ $inspection->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr class="text-center">
                        <th colspan="4" scope="col">Lista de Extintores pasados y proximos</th>
                    </tr>
                    <tr>
                        <th scope="col">Equipo/Maquinaria</th>
                        <th scope="col">Fecha de expiracion</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($extinguishers as $extinguisher)
                        <tr class="table-light">
                            <td scope="row">{{ $inspection->equipment_machinery->name }}</td>
                            <td>{{ $inspection->extinguisher_expiration }}</td>
                            <td>{{ $inspection->extinguisher_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr class="text-center">
                        <th colspan="4" scope="col">Lista de Mantenimientos pasados y proximos</th>
                    </tr>
                    <tr>
                        <th scope="col">Equipo/Maquinaria</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr class="table-light">
                            <td scope="row">{{ $schedule->equipment->name }}</td>
                            <td>{{ $schedule->date }}</td>
                            <td>{{ $schedule->description }}</td>
                            <td>{{ $schedule->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr class="text-center">
                        <th colspan="4" scope="col">Lista de Documentos Proximos y Vencidos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center" colspan="3">Soat</th>
                    </tr>
                    @forelse ($documents['equipment_machinery_soats'] as $soat)
                        <tr class="table-light">
                            <td scope="row">{{ $soat->equipment_machinery->name }}</td>
                            <td>{{ $soat->validity }}</td>
                            <td>{{ $soat->status }}</td>
                        </tr>
                    @empty
                        <tr class="table-light">
                            <td colspan="3">No hay registros de Soat Pendientes.</td>
                        </tr>
                    @endforelse

                    <tr>
                        <th class="text-center" colspan="3">Seguro</th>
                    </tr>
                    @forelse ($documents['equipment_machinery_sure'] as $sure)
                        <tr class="table-light">
                            <td scope="row">{{ $sure->equipment_machinery->name }}</td>
                            <td>{{ $sure->validity }}</td>
                            <td>{{ $sure->status }}</td>
                        </tr>
                    @empty
                        <tr class="table-light">
                            <td colspan="3">No hay registros de Seguro Pendientes.</td>
                        </tr>
                    @endforelse

                    <tr>
                        <th class="text-center" colspan="3">Tecnicomecanica</th>
                    </tr>
                    @forelse ($documents['equipment_machinery_techno'] as $techno)
                        <tr class="table-light">
                            <td scope="row">{{ $techno->equipment_machinery->name }}</td>
                            <td>{{ $techno->date_revision }}</td>
                            <td>{{ $techno->status }}</td>
                        </tr>
                    @empty
                        <tr class="table-light">
                            <td colspan="3">No hay registros de Tecnicomecanica Pendientes.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>


        <p>Saludos cordiales.</p>
    </div>
</body>

</html>
