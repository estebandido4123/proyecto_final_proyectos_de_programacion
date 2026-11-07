<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuariosModel; 

class LoginController extends BaseController
{
    public function index()
    {
        // Carga la vista inicial del login
        return view('login');
    }

    public function autenticar()
    {
        $usuario = $this->request->getPost('nombre_usuario');
        $contrasena = $this->request->getPost('contrasena');

        $usuariosModel = new UsuariosModel();
        // Buscar el usuario en la base de datos
        $datosUsuario = $usuariosModel->where('nombre_usuario', $usuario)->first();

        // Verificar si el usuario existe y si la contraseña coincide
        if ($datosUsuario && password_verify($contrasena, $datosUsuario['contrasena'])) {
            
            // Iniciar sesión y guardar datos del usuario
            $session = session();
            $session->set([
                'id_usuario'     => $datosUsuario['id_usuario'],
                'nombre_usuario' => $datosUsuario['nombre_usuario'],
                'nombres'        => $datosUsuario['nombres'],
                'id_rol'         => $datosUsuario['id_rol'],
                'logged_in'      => true
            ]);

            // Cargar directamente las vistas correspondientes según el rol
            if ($datosUsuario['id_rol'] == 1) { 
                // Carga vista_administrador.php
                return view('vista_administrador'); 
            } else if ($datosUsuario['id_rol'] == 2) { 
                // Carga vista_estudiante.php
                return view('vista_estudiante'); 
            } else if ($datosUsuario['id_rol'] == 3) { 
                // Carga vista_profesor.php
                return view('vista_profesor'); 
            }

        } else {
            // Regresar al formulario con un mensaje de error si falla
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        }
    }
    
public function salir()
    {
        $session = session();
        $session->destroy();
        // Cambiar 'LoginController' por '/' para ir a la página principal
        return redirect()->to(base_url('/')); 
    }

}