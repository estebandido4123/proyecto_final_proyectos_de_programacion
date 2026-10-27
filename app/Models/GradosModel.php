<?php namespace App\Models;

use CodeIgniter\Model;

class GradosModel extends Model
{
    protected $table      = 'grados';
    protected $primaryKey = 'id_grado';
    protected $allowedFields = [
        'nombre_grado'
    ];
}