<?php namespace App\Models;

use CodeIgniter\Model;

class CatalogoLibrosModel extends Model
{
    protected $table      = 'catalogo_libros';
    protected $primaryKey = 'id_libro';
    protected $allowedFields = [
        'titulo',
        'id_grado'
    ];
}