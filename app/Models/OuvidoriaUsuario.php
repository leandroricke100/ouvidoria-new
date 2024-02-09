<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvidoriaUsuario extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ouvidoria_usuarios';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function administrador()
    {
        return $this->admin == 1;
    }
}
