<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #495057;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* Columna de Formulario */
        .login-section {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 4rem;
        }

        .brand-header {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #6c757d;
            margin-bottom: 4rem;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        /* Estilo Minimalista para Inputs floating/outlined */
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating-custom input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background-color: #ffffff;
            color: #212529;
        }

        .form-floating-custom input:focus {
            border-color: #b3c5ea;
            box-shadow: 0 0 0 4px rgba(179, 197, 234, 0.25);
        }

        .form-floating-custom label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            margin-bottom: 0.4rem;
        }

        .btn-custom {
            background-color: #7b9acc;
            border: none;
            color: #ffffff;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .btn-custom:hover {
            background-color: #6887b8;
            color: #ffffff;
        }

        /* Columna de Arte/Decoración Visual */
        .art-section {
            background: linear-gradient(135deg, #e3eeff 0%, #f3e7e9 50%, #e3eeff 100%);
            position: relative;
            overflow: hidden;
        }

        .art-graphic {
            width: 100%;
            height: 100%;
            opacity: 0.6;
            background: radial-gradient(circle at 30% 30%, rgba(186, 215, 233, 0.8), transparent 50%),
                        radial-gradient(circle at 70% 70%, rgba(227, 207, 222, 0.8), transparent 50%);
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 login-wrapper">
        
        <!-- Panel Izquierdo: Formulario -->
        <div class="col-12 col-md-6 col-lg-5 login-section">
            <div class="brand-header">
                BIBLIOTECA ESCOLAR
            </div>

            <div class="w-100" style="max-width: 380px; margin: 0 auto;">
                <h2 class="login-title">Ingreso al Sistema</h2>
                <p class="login-subtitle">Introduce tus credenciales para acceder</p>

                <!-- Bloque de visualización de errores -->
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger text-center py-2 mb-4" style="font-size: 0.875rem; border-radius: 8px;">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('LoginController/autenticar') ?>" method="POST">
                    
                    <div class="form-floating-custom">
                        <label for="nombre_usuario">Usuario</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" autocomplete="off" required>
                    </div>

                    <div class="form-floating-custom">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-custom">Iniciar Sesión</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Panel Derecho: Fondo Ilustrativo Pastel Minimalista -->
        <div class="col-md-6 col-lg-7 d-none d-md-block art-section">
            <div class="art-graphic"></div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>