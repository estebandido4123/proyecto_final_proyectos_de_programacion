<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Biblioteca Escolar</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e3e6f0;
        }
        .btn-custom-blue {
            background-color: #7b9cc0; 
            color: #ffffff;
            border: none;
        }
        .btn-custom-blue:hover {
            background-color: #688ab0;
            color: #ffffff;
        }
        .table-pastel thead {
            background-color: #edf2f7;
            color: #4a5568;
        }
        .nav-pills .nav-link {
            color: #718096;
        }
        .nav-pills .nav-link.active {
            background-color: #7b9cc0;
            color: white;
        }
        .card-custom {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg topbar py-3 shadow-sm mb-4">
    <div class="container-fluid px-4">
        <span class="navbar-brand text-secondary fw-bold" style="letter-spacing: 1px; font-size: 0.9rem;">
            BIBLIOTECA ESCOLAR - MÓDULO ADMINISTRATIVO
        </span>
        <div class="d-flex">
            <span class="navbar-text me-3 text-muted">
                <i class="bi bi-person-circle"></i> Administrador
            </span>
            <a href="<?= base_url('LoginController/salir') ?>" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Salir
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid px-4">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 mb-4">
            <div class="card card-custom p-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active mb-2 text-start" id="v-pills-libros-tab" data-bs-toggle="pill" data-bs-target="#v-pills-libros" type="button" role="tab" aria-controls="v-pills-libros" aria-selected="true">
                        <i class="bi bi-book me-2"></i> Gestión de Libros
                    </button>
                    <button class="nav-link mb-2 text-start" id="v-pills-profesores-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profesores" type="button" role="tab" aria-controls="v-pills-profesores" aria-selected="false">
                        <i class="bi bi-person-video3 me-2"></i> Profesores
                    </button>
                    <button class="nav-link mb-2 text-start" id="v-pills-estudiantes-tab" data-bs-toggle="pill" data-bs-target="#v-pills-estudiantes" type="button" role="tab" aria-controls="v-pills-estudiantes" aria-selected="false">
                        <i class="bi bi-people me-2"></i> Estudiantes
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="tab-content" id="v-pills-tabContent">
                
                <!-- Pestaña Libros -->
                <div class="tab-pane fade show active" id="v-pills-libros" role="tabpanel" aria-labelledby="v-pills-libros-tab">
                    <div class="card card-custom p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="text-secondary m-0">Catálogo de Libros</h4>
                            <button type="button" class="btn btn-custom-blue" data-bs-toggle="modal" data-bs-target="#modalLibro">
                                <i class="bi bi-plus-lg"></i> Añadir Libro
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-pastel align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Grado Recomendado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>El Señor Presidente</td>
                                        <td>3ro Básico</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Profesores -->
                <div class="tab-pane fade" id="v-pills-profesores" role="tabpanel" aria-labelledby="v-pills-profesores-tab">
                    <div class="card card-custom p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="text-secondary m-0">Registro de Profesores</h4>
                            <button type="button" class="btn btn-custom-blue" data-bs-toggle="modal" data-bs-target="#modalProfesor">
                                <i class="bi bi-person-plus"></i> Añadir Profesor
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-pastel align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Usuario</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($profesores)): ?>
                                        <?php foreach($profesores as $profe): ?>
                                        <tr>
                                            <td><?= $profe['id_usuario'] ?></td>
                                            <td><?= $profe['nombres'] ?></td>
                                            <td><?= $profe['apellidos'] ?></td>
                                            <td><?= $profe['nombre_usuario'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash3"></i></button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No hay profesores registrados</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Estudiantes -->
                <div class="tab-pane fade" id="v-pills-estudiantes" role="tabpanel" aria-labelledby="v-pills-estudiantes-tab">
                    <div class="card card-custom p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="text-secondary m-0">Registro de Estudiantes</h4>
                            <button type="button" class="btn btn-custom-blue" data-bs-toggle="modal" data-bs-target="#modalEstudiante">
                                <i class="bi bi-person-plus"></i> Añadir Estudiante
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-pastel align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>ID Grado</th>
                                        <th>Usuario</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($estudiantes)): ?>
                                        <?php foreach($estudiantes as $estudiante): ?>
                                        <tr>
                                            <td><?= $estudiante['id_usuario'] ?></td>
                                            <td><?= $estudiante['nombres'] ?></td>
                                            <td><?= $estudiante['apellidos'] ?></td>
                                            <td><?= $estudiante['id_grado'] ?></td>
                                            <td><?= $estudiante['nombre_usuario'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash3"></i></button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No hay estudiantes registrados</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ================= MODALES ================= -->

<div class="modal fade" id="modalLibro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-secondary">Registrar Nuevo Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label text-muted">Título del Libro</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Grado Recomendado</label>
                        <select class="form-select">
                            <option selected disabled>Seleccione un grado...</option>
                            <option value="1">3ro Básico</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-custom-blue">Guardar Libro</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProfesor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-secondary">Registrar Profesor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nombres</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Apellidos</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Nombre de Usuario</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Contraseña temporal</label>
                        <input type="password" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-custom-blue">Guardar Profesor</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEstudiante" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-secondary">Registrar Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nombres</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Apellidos</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Grado</label>
                        <select class="form-select" required>
                            <option selected disabled>Seleccione un grado...</option>
                            <option value="1">3ro Básico</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Nombre de Usuario</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Contraseña temporal</label>
                        <input type="password" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-custom-blue">Guardar Estudiante</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>