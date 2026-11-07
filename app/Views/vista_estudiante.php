<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estudiante - Biblioteca Escolar</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        .topbar { 
            background-color: #ffffff; 
            border-bottom: 1px solid #e3e6f0; 
        }
        .book-card {
            border: 1px solid #eaeaea;
            border-radius: 12px;
            background-color: #ffffff;
            transition: transform 0.2s ease-in-out;
            height: 100%;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        .book-cover-block {
            background-color: #dde4ed; 
            border-radius: 8px;
            min-height: 140px;
            position: relative;
            padding: 20px;
            display: flex;
            align-items: center;
        }
        .grade-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #ffffff;
            color: #333;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .book-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            margin-top: 20px; 
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            display: inline-block;
        }
        .status-prestado {
            background-color: #fef0c7;
            color: #b54708;
        }
        .status-devuelto {
            background-color: #d1fadf;
            color: #039855;
        }
        .btn-action {
            background-color: #7b9cc0;
            color: white;
            border: none;
            width: 100%;
            border-radius: 6px;
            padding: 8px;
            font-weight: 500;
        }
        .btn-action:hover {
            background-color: #688ab0;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg topbar py-3 shadow-sm mb-4">
    <div class="container-fluid px-4">
        <span class="navbar-brand text-dark fw-bold" style="letter-spacing: 0.5px; font-size: 1.1rem;">
            BIBLIOTECA ESCOLAR — PANEL DE ESTUDIANTE
        </span>
        <div class="d-flex align-items-center">
            <span class="navbar-text me-4 text-muted small">
                Estudiante: <strong><?= $nombre_estudiante ?></strong>
            </span>
            <a href="<?= base_url('LoginController/salir') ?>" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                Cerrar Sesión
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 mb-5">
    
    <!-- Pestañas -->
    <ul class="nav nav-tabs mb-4 border-bottom-0" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-dark border-0 border-bottom border-3 border-primary" id="activos-tab" data-bs-toggle="tab" data-bs-target="#activos" type="button" role="tab">
                <i class="bi bi-book-half me-1"></i> Mis Préstamos Activos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-secondary border-0" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab">
                <i class="bi bi-clock-history me-1"></i> Historial de Lectura
            </button>
        </li>
    </ul>

    <!-- Contenido de las Pestañas -->
    <div class="tab-content" id="myTabContent">
        
        <!-- Pestaña Activos -->
        <div class="tab-pane fade show active" id="activos" role="tabpanel">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php if(!empty($activos)): foreach($activos as $prestamo): ?>
                <div class="col">
                    <div class="book-card p-3 shadow-sm d-flex flex-column">
                        <div class="book-cover-block mb-3">
                            <span class="grade-badge"><?= $prestamo['nombre_grado'] ?? 'Uso General' ?></span>
                            <h5 class="book-title"><?= $prestamo['titulo'] ?></h5>
                        </div>
                        <div class="px-2 mb-3 flex-grow-1">
                            <p class="text-muted small mb-2"><i class="bi bi-calendar3"></i> Fecha de préstamo: <strong><?= $prestamo['fecha_prestamo'] ?></strong></p>
                            <span class="status-badge status-prestado">Prestado</span>
                        </div>
                        <div class="mt-auto px-2">
                            <button class="btn btn-action" disabled>Libro en uso</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="col-12">
                    <div class="alert border text-center p-5 text-muted bg-white rounded-3">
                        <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                        No tienes ningún libro prestado en este momento.
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pestaña Historial -->
        <div class="tab-pane fade" id="historial" role="tabpanel">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php if(!empty($historial)): foreach($historial as $prestamo): ?>
                <div class="col">
                    <div class="book-card p-3 shadow-sm d-flex flex-column" style="opacity: 0.85;">
                        <div class="book-cover-block mb-3 bg-light">
                            <span class="grade-badge border text-muted"><?= $prestamo['nombre_grado'] ?? 'Uso General' ?></span>
                            <h5 class="book-title text-muted"><?= $prestamo['titulo'] ?></h5>
                        </div>
                        <div class="px-2 mb-3 flex-grow-1">
                            <p class="text-muted small mb-1"><i class="bi bi-calendar3"></i> Préstamo: <?= $prestamo['fecha_prestamo'] ?></p>
                            <p class="text-muted small mb-2"><i class="bi bi-calendar-check"></i> Devolución: <strong><?= $prestamo['fecha_devolucion'] ?></strong></p>
                            <span class="status-badge status-devuelto">Devuelto</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="col-12">
                    <div class="alert border text-center p-5 text-muted bg-white rounded-3">
                        <i class="bi bi-clock fs-1 d-block mb-3"></i>
                        Aún no tienes historial de libros devueltos.
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>
</html>