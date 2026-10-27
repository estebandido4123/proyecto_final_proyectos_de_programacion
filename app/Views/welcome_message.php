<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Escolar - Colegio Nuevos Horizontes</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #2b3a67; 
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            text-align: center;
        }

        .logo-img {
            width: 100px;
            margin-bottom: 1rem;
        }

        h2 {
            color: #2b3a67;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 0.2rem;
        }

        .subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        /* Selector de Roles */
        .role-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 2rem;
        }

        .btn-role {
            flex: 1;
            border-radius: 30px;
            padding: 0.6rem;
            font-weight: 500;
            font-size: 0.9rem;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background-color: #f4f1ea; /* Tono café muy claro */
            color: #495057;
        }

        .btn-role.active[data-role="estudiante"] {
            background-color: #a3c4d9; /* Azul suave */
            color: #1a252f;
            border-color: #a3c4d9;
        }

        .btn-role.active[data-role="personal"] {
            background-color: #e4c5c4; /* Rosa apagado */
            color: #2d2422;
            border-color: #e4c5c4;
        }

        .input-group-custom {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border-radius: 30px;
            border: 2px solid #e9ecef;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #a3c4d9;
            background-color: #ffffff;
        }

        /* Botón de Submit principal */
        .btn-submit {
            background-color: #2b3a67;
            color: white;
            border-radius: 30px;
            padding: 0.8rem;
            width: 100%;
            font-weight: 600;
            letter-spacing: 1px;
            border: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-submit:hover {
            background-color: #1e294b;
            transform: translateY(-2px);
        }

        #selected_role {
            display: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        
       <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="Logo Colegio Nuevos Horizontes" class="logo-img">        
        <h2>SISTEMA INTEGRAL</h2>
        <p class="subtitle">Biblioteca y Control de Asistencia</p>

        <form action="<?= base_url('login') ?>" method="POST" id="loginForm">
            
            <!-- Selector de Rol (UI) -->
            <div class="role-selector">
                <button type="button" class="btn-role active" data-role="estudiante">
                    <i class="fa-solid fa-user-graduate"></i> Estudiante
                </button>
                <button type="button" class="btn-role" data-role="personal">
                    <i class="fa-solid fa-chalkboard-user"></i> Personal
                </button>
            </div>
            
            <input type="hidden" name="rol_ingreso" id="rol_ingreso" value="estudiante">

            <div class="input-group-custom">
                <i class="fa-regular fa-user"></i>
                <input type="text" name="usuario" class="form-control-custom" placeholder="Ingrese su nombre de usuario" required>
            </div>

            <div class="input-group-custom">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="contrasena" class="form-control-custom" placeholder="Ingrese contraseña" required>
            </div>

            <button type="submit" class="btn-submit">
                INICIAR SESIÓN
            </button>
        </form>
        <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show text-start py-2 px-3 mb-3" style="border-radius: 15px; font-size: 0.85rem;" role="alert">
        <i class="fa-solid fa-circle-exclamation me-1"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

    </div>

    <!-- Mensaje de alerta para errores de login -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Lógica para cambiar el rol seleccionado
            $('.btn-role').on('click', function() {
                $('.btn-role').removeClass('active');
                
                $(this).addClass('active');
                
                var selectedRole = $(this).data('role');
                $('#rol_ingreso').val(selectedRole);

                $('.input-group-custom').hide().fadeIn(300);
            });

            $('#loginForm').on('submit', function() {
                var $btn = $('.btn-submit');
                $btn.html('<i class="fa-solid fa-circle-notch fa-spin"></i> VERIFICANDO...');
                $btn.prop('disabled', true);
            });
        });
    </script>
</body>
</html>