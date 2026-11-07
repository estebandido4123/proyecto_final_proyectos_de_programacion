<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <h1>Bienvenido al Panel de profesor</h1>
            <a href="<?= base_url('LoginController/salir') ?>" class="btn btn-danger mt-3">Cerrar Sesión</a>
        </div>
    </div>
</div>

</body>
</html>