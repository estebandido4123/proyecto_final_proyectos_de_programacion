<?php namespace App\Models;

use CodeIgniter\Model;

class PrestamosModel extends Model
{
    protected $table      = 'prestamos';
    protected $primaryKey = 'id_prestamo';
    protected $allowedFields = [
        'id_usuario',
        'id_ejemplar',
        'fecha_prestamo',
        'fecha_devolucion'
    ];
}