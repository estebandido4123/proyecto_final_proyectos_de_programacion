<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuariosModel; 

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function autenticar()
    {
        $usuario =$this->request->getPost('nombre_usuario');
        $contrasena =$this->request->getPost('contrasena');

        $usuariosModel = new UsuariosModel();$datosUsuario = $usuariosModel->where('nombre_usuario',$usuario)->first();

        if ($datosUsuario && password_verify($contrasena,$datosUsuario['contrasena'])) {
            
            $session = session();$session->set([
                'id_usuario'     => $datosUsuario['id_usuario'],
                'nombre_usuario' => $datosUsuario['nombre_usuario'],
                'nombres'        => $datosUsuario['nombres'],
                'id_rol'         => $datosUsuario['id_rol'],
                'logged_in'      => true
            ]);

            // Cargar vistas según el rol
            if ($datosUsuario['id_rol'] == 1) { 
                
                // Extraer profesores (rol 3) y estudiantes (rol 2)
                $data = [
                    'profesores'  => $usuariosModel->where('id_rol', 3)->findAll(),
                    'estudiantes' => $usuariosModel->where('id_rol', 2)->findAll()
                ];
                
                return view('vista_administrador', $data);
                
            } else if ($datosUsuario['id_rol'] == 2) { return view('vista_estudiante'); } else if ($datosUsuario['id_rol'] == 3) { 
                return view('vista_profesor'); 
            }

        } else {
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        }
    }
    
    public function salir()
    {
        $session = session();$session->destroy();
        return redirect()->to(base_url('/'));
    }

    // Mantengo esta función por si necesitas resetear las claves en el futuro
    public function generarClave()
    {
        $usuariosModel = new \App\Models\UsuariosModel();$nuevaContrasena = password_hash('password123', PASSWORD_BCRYPT);
        
        $usuariosModel->where('nombre_usuario', 'admin')->set(['contrasena' =>$nuevaContrasena])->update();
        $usuariosModel->where('nombre_usuario', 'vchet')->set(['contrasena' =>$nuevaContrasena])->update();
        $usuariosModel->where('nombre_usuario', 'pgustavo')->set(['contrasena' =>$nuevaContrasena])->update();
                      
        echo "Contraseñas actualizadas con éxito a: password123. Ya puedes ir al login.";
    }
}