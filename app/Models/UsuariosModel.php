<?php namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'id_rol',
        'id_grado',
        'nombre_usuario',
        'contrasena'
    ];
}