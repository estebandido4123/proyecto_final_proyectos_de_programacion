<?php namespace App\Models;

use CodeIgniter\Model;

class EjemplaresFisicosModel extends Model
{
    protected $table      = 'ejemplares_fisicos';
    protected $primaryKey = 'id_ejemplar';
    protected $allowedFields = [
        'id_libro',
        'codigo_interno',
        'disponibilidad'
    ];
}