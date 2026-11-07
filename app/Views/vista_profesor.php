<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Profesor - Biblioteca Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        :root {
            --bg-canvas: #f8f9fa;
            --panel-bg: #ffffff;
            --primary-pastel: #8da9c4;
            --primary-hover: #7395b7;
            --soft-mint: #e2ece9;
            --soft-yellow: #fff3bf;
            --text-main: #2b2d42;
            --text-muted: #6c757d;
            --border-color: #eaeaea;
        }

        body {
            background-color: var(--bg-canvas);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background-color: var(--panel-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1.2rem 2.5rem;
        }

        .brand-title {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--text-main);
        }

        .search-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            margin-bottom: 2.5rem;
        }

        .form-control-custom, .form-select-custom {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            color: var(--text-main);
            background-color: #fafafa;
        }

        .form-control-custom:focus, .form-select-custom:focus {
            border-color: var(--primary-pastel);
            box-shadow: 0 0 0 3px rgba(141, 169, 196, 0.2);
            outline: none;
            background-color: #ffffff;
        }

        .book-card {
            background: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.05);
        }

        .book-visual {
            height: 180px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            border-left: 5px solid var(--primary-pastel);
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, #eef3f8 0%, #dbe5f0 100%);
        }

        .book-badge-grade {
            align-self: flex-start;
            background-color: #ffffff;
            color: var(--text-main);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
        }

        .book-cover-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.3;
            z-index: 1;
        }

        .status-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            margin-top: 0.4rem;
        }

        .status-disponible {
            background-color: var(--soft-mint);
            color: #2b6c59;
        }

        .status-prestado {
            background-color: var(--soft-yellow);
            color: #745e00;
        }

        .book-details-list {
            list-style: none;
            padding: 0;
            margin: 0.8rem 0;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .btn-pastel-primary {
            background-color: var(--primary-pastel);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .btn-pastel-primary:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
        }

        .btn-pastel-secondary {
            background-color: var(--soft-yellow);
            color: #5c4b00;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .btn-outline-custom {
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            background: transparent;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
        }

        .modal-content-custom {
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.5rem;
            background-color: var(--panel-bg);
        }

        .modal-header-custom {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .label-custom {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
            display: block;
        }

        .detail-box {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            margin-bottom: 0.85rem;
            border: 1px solid #f0f0f0;
        }

        .detail-box span {
            display: block;
            font-size: 0.95rem;
            color: var(--text-main);
            font-weight: 600;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
    <div class="brand-title">
        BIBLIOTECA ESCOLAR &mdash; PANEL DE PROFESOR
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted small">Profesor: <?= esc(session()->get('nombres')) ?></span>
        <a href="<?= base_url('LoginController/salir') ?>" class="btn btn-outline-custom">Cerrar Sesión</a>
    </div>
</nav>

<div class="container-fluid px-4 py-4">

    <!-- Mensajes Flashdata de Notificación -->
    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success text-center border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Buscador y Filtros Activos -->
    <div class="search-card">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="label-custom" for="filter-text">Buscar Libro</label>
                <input type="text" id="filter-text" class="form-control form-control-custom" placeholder="Buscar por título o autor...">
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label class="label-custom" for="filter-grado">Grado Destinado</label>
                <select id="filter-grado" class="form-select form-select-custom">
                    <option value="">Todos los grados</option>
                    <?php foreach($grados as $g): ?>
                        <option value="<?= $g['id_grado'] ?>"><?= esc($g['nombre_grado']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label class="label-custom" for="filter-estado">Estado</label>
                <select id="filter-estado" class="form-select form-select-custom">
                    <option value="">Todos los estados</option>
                    <option value="disponible">Disponible</option>
                    <option value="prestado">Prestado</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Renderizado Dinámico del Catálogo de Libros -->
    <div class="row g-4" id="books-container">
        <?php if(!empty($libros)): ?>
            <?php foreach($libros as $libro): ?>
                <?php 
                    $estadoLibro = $libro['disponible'] ? 'disponible' : 'prestado';
                    $idGrado = $libro['id_grado'] ?? '';
                ?>
                <!-- Columna contenedora con data-attributes para filtrado de JavaScript -->
                <div class="col-12 col-sm-6 col-md-4 book-item" 
                     data-titulo="<?= strtolower(esc($libro['titulo'])) ?>" 
                     data-autor="<?= strtolower(esc($libro['autores'] ?? '')) ?>" 
                     data-grado="<?= esc($idGrado) ?>" 
                     data-estado="<?= $estadoLibro ?>">
                    
                    <div class="book-card">
                        <div>
                            <div class="book-visual">
                                <span class="book-badge-grade"><?= esc($libro['nombre_grado'] ?? 'General') ?></span>
                                <div class="book-cover-title"><?= esc($libro['titulo']) ?></div>
                            </div>
                            
                            <ul class="book-details-list">
                                <li><strong>Autor(es):</strong> <?= esc($libro['autores'] ?? 'No especificado') ?></li>
                                <li>
                                    <?php if($libro['disponible']): ?>
                                        <span class="status-badge status-disponible">Disponible</span>
                                    <?php else: ?>
                                        <span class="status-badge status-prestado">Prestado</span>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-pastel-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalLibro<?= $libro['id_libro'] ?>">Ver Detalles y Gestionar</button>
                    </div>
                </div>

                <!-- Modal para cada Libro recuperado de la BD -->
                <div class="modal fade" id="modalLibro<?= $libro['id_libro'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content modal-content-custom">
                            <div class="modal-header-custom d-flex justify-content-between align-items-center">
                                <h5 class="m-0 fw-bold">Información del Libro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-4 mb-4">
                                    <div class="col-12 col-md-5">
                                        <div class="book-visual h-100 min-vh-25">
                                            <span class="book-badge-grade"><?= esc($libro['nombre_grado'] ?? 'General') ?></span>
                                            <div class="book-cover-title fs-4"><?= esc($libro['titulo']) ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="detail-box">
                                            <label class="label-custom">Autor(es)</label>
                                            <span><?= esc($libro['autores'] ?? 'No registrado') ?></span>
                                        </div>
                                        <div class="detail-box">
                                            <label class="label-custom">Grado Destinado</label>
                                            <span><?= esc($libro['nombre_grado'] ?? 'Todos los grados') ?></span>
                                        </div>
                                        <div class="detail-box">
                                            <label class="label-custom">Estado del Ejemplar</label>
                                            <span><?= $libro['disponible'] ? 'Disponible para Préstamo' : 'Prestado actualmente' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <!-- Formulario de Asignación a Estudiante -->
                                    <div class="col-12 col-md-6 border-end pe-md-4">
                                        <h6 class="fw-bold mb-3">Asignar a Estudiante</h6>
                                        <?php if($libro['disponible']): ?>
                                            <form action="<?= base_url('profesor/asignarLibro') ?>" method="POST">
                                                <input type="hidden" name="id_ejemplar" value="<?= $libro['id_ejemplar_disponible'] ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="label-custom" for="estudiante">Estudiante</label>
                                                    <select class="form-select form-select-custom" name="id_usuario" required>
                                                        <option value="">Seleccionar Estudiante</option>
                                                        <?php foreach($estudiantes as $e): ?>
                                                            <option value="<?= $e['id_usuario'] ?>"><?= esc($e['nombres'] . ' ' . $e['apellidos']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-pastel-primary w-100">Confirmar Asignación</button>
                                            </form>
                                        <?php else: ?>
                                            <p class="text-muted small">No hay ejemplares disponibles de esta obra para asignar.</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Formulario de Devolución -->
                                    <div class="col-12 col-md-6 ps-md-4 mt-4 mt-md-0">
                                        <h6 class="fw-bold mb-3">Procesar Devolución</h6>
                                        <?php if(!empty($libro['prestamos_activos'])): ?>
                                            <form action="<?= base_url('profesor/devolverLibro') ?>" method="POST">
                                                <div class="mb-3">
                                                    <label class="label-custom" for="prestamo">Estudiantes con Préstamo Activo</label>
                                                    <select class="form-select form-select-custom" name="id_prestamo" required>
                                                        <option value="">Seleccionar Alumno / Ejemplar</option>
                                                        <?php foreach($libro['prestamos_activos'] as $p): ?>
                                                            <option value="<?= $p['id_prestamo'] ?>">
                                                                <?= esc($p['nombres'] . ' ' . $p['apellidos']) ?> (F. Préstamo: <?= $p['fecha_prestamo'] ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-pastel-secondary w-100">Registrar Devolución</button>
                                            </form>
                                        <?php else: ?>
                                            <p class="text-muted small">Este libro no tiene devoluciones pendientes.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5 text-muted">
                No hay libros registrados en el catálogo.
            </div>
        <?php endif; ?>
    </div>

    <!-- Mensaje dinámico cuando ningún libro coincide con los filtros -->
    <div id="no-results-msg" class="text-center py-5 text-muted d-none">
        No se encontraron libros que coincidan con los filtros seleccionados.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<!-- Script de Filtrado Dinámico -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterText = document.getElementById('filter-text');
    const filterGrado = document.getElementById('filter-grado');
    const filterEstado = document.getElementById('filter-estado');
    const bookItems = document.querySelectorAll('.book-item');
    const noResultsMsg = document.getElementById('no-results-msg');

    function applyFilters() {
        const textValue = filterText.value.toLowerCase().trim();
        const gradoValue = filterGrado.value;
        const estadoValue = filterEstado.value;
        let visibleCount = 0;

        bookItems.forEach(function (item) {
            const title = item.getAttribute('data-titulo') || '';
            const author = item.getAttribute('data-autor') || '';
            const grado = item.getAttribute('data-grado') || '';
            const estado = item.getAttribute('data-estado') || '';

            // Validación individual de cada filtro
            const matchesText = textValue === '' || title.includes(textValue) || author.includes(textValue);
            const matchesGrado = gradoValue === '' || grado === gradoValue;
            const matchesEstado = estadoValue === '' || estado === estadoValue;

            if (matchesText && matchesGrado && matchesEstado) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        // Mostrar o ocultar el aviso si la búsqueda no arroja resultados
        if (visibleCount === 0 && bookItems.length > 0) {
            noResultsMsg.classList.remove('d-none');
        } else {
            noResultsMsg.classList.add('d-none');
        }
    }

    // Escuchar eventos de cambio en los tres controles
    filterText.addEventListener('input', applyFilters);
    filterGrado.addEventListener('change', applyFilters);
    filterEstado.addEventListener('change', applyFilters);
});
</script>

</body>
</html>