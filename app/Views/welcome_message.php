<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Biblioteca Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        :root {
            --navy-border: #1b2a4a;
            --navy-text: #0f172a;
            --navy-muted: #334155;
            --btn-bg: #4a6fa5;
            --btn-hover: #3b5984;
            --bg-light: #f8fafc;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--navy-text);
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* Columna Izquierda: Formulario */
        .login-section {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 4rem;
            border-right: 1.5px solid rgba(27, 42, 74, 0.15);
        }

        .brand-header {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--navy-border);
            margin-bottom: 3.5rem;
            text-transform: uppercase;
        }

        .login-title {
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--navy-text);
            margin-bottom: 0.35rem;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: var(--navy-muted);
            margin-bottom: 2.25rem;
        }

        /* Formulario con bordes marinos */
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating-custom label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--navy-border);
            margin-bottom: 0.4rem;
        }

        .form-floating-custom input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            border: 1.5px solid rgba(27, 42, 74, 0.25);
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background-color: #ffffff;
            color: var(--navy-text);
        }

        .form-floating-custom input:focus {
            border-color: var(--navy-border);
            box-shadow: 0 0 0 3px rgba(27, 42, 74, 0.12);
        }

        .btn-custom {
            background-color: var(--btn-bg);
            border: 1.5px solid var(--navy-border);
            color: #ffffff;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .btn-custom:hover {
            background-color: var(--btn-hover);
            color: #ffffff;
        }

        /* Columna Derecha: Carrusel con Fondos Degradados Más Intensos */
        .carousel-section {
            padding: 0;
            height: 100vh;
        }

        .carousel, .carousel-inner, .carousel-item {
            height: 100%;
        }

        /* Degradados pastel vivos */
        .slide-bg-1 {
            background: linear-gradient(135deg, #a8c0ff 0%, #fbc2eb 100%);
        }

        .slide-bg-2 {
            background: linear-gradient(135deg, #a8e6cf 0%, #88d8b0 50%, #9be15d 100%);
        }

        .slide-bg-3 {
            background: linear-gradient(135deg, #ffb199 0%, #ff0844 100%);
        }

        .carousel-caption-custom {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            text-align: center;
        }

        /* Frases limpias sobre fondo transparente */
        .carousel-text-box {
            background: transparent;
            max-width: 540px;
        }

        .carousel-text-box h3 {
            color: #1e293b;
            font-weight: 800;
            font-size: 2.1rem;
            margin-bottom: 1.25rem;
            letter-spacing: -0.5px;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.4);
        }

        .carousel-text-box p {
            color: #334155;
            font-size: 1.05rem;
            line-height: 1.6;
            margin: 0;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .carousel-indicators [data-bs-target] {
            background-color: #1e293b;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin: 0 5px;
            opacity: 0.4;
        }

        .carousel-indicators .active {
            opacity: 0.9;
            width: 22px;
            border-radius: 4px;
        }

        .img-placeholder {
            width: 100%;
            max-width: 400px;
            height: 200px;
            background-color: rgba(255, 255, 255, 0.4);
            border: 2px dashed rgba(255, 255, 255, 0.6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            color: #334155;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 login-wrapper">
        
        <!-- Panel Izquierdo: Formulario -->
        <div class="col-12 col-md-6 col-lg-5 login-section">
            <div class="brand-header">
                Biblioteca Escolar Virtual
            </div>

            <div class="w-100" style="max-width: 380px; margin: 0 auto;">
                <h2 class="login-title">Ingreso al Sistema</h2>
                <p class="login-subtitle">Introduce tus credenciales para acceder</p>

                <!-- Bloque de errores en la sesión -->
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger text-center py-2 mb-4" style="font-size: 0.875rem; border: 1px solid rgba(27, 42, 74, 0.2); border-radius: 8px;">
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

        <!-- Panel Derecho: Carrusel de frases dinámicas sin recuadros -->
        <div class="col-md-6 col-lg-7 d-none d-md-block carousel-section">
            <div id="loginCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
                
                <div class="carousel-indicators mb-4">
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Frase 1"></button>
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="1" aria-label="Frase 2"></button>
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="2" aria-label="Frase 3"></button>
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="3" aria-label="Equipo"></button>
                </div>

                <div class="carousel-inner">
                    
                    <!-- Slide 1 -->
                    <div class="carousel-item active slide-bg-1">
                        <div class="carousel-caption-custom">
                            <div class="carousel-text-box">
                                <h3>Bienvenido a la Biblioteca Virtual</h3>
                                <p>Un espacio creado para descubrir nuevos conocimientos y acompañarte en cada etapa de tu aprendizaje.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item slide-bg-2">
                        <div class="carousel-caption-custom">
                            <div class="carousel-text-box">
                                <h3>Explora y Aprende</h3>
                                <p>Accede a nuestro catálogo de lecturas y recursos digitales organizados para enriquecer cada clase.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item slide-bg-3">
                        <div class="carousel-caption-custom">
                            <div class="carousel-text-box">
                                <h3>Lectura a tu Alcance</h3>
                                <p>Gestiona y asigna libros de manera sencilla y ordenada en un entorno pensado para la comunidad escolar.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Equipo de Desarrollo -->
                    <div class="carousel-item slide-bg-1"> <!-- Puedes cambiar la clase de fondo si lo deseas -->
                        <div class="carousel-caption-custom">
                            <div class="carousel-text-box">
                                <h3>Equipo de Desarrollo</h3>
                                
                                <!-- Espacio para la imagen -->
                                <div class="img-placeholder">
                                   <img src="assets/img/vivi_and_me.jpeg" alt="" class="img" style="width:100%; height:100%;    ">
                                </div>

                                <p class="mb-2"><strong>201900209</strong> - Francisco Javier Godoy Espinoza</p>
                                <p><strong>202402334</strong> - Vivian Yesenia Chet Chacach</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>