<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvidoriaConfiguracao extends Model
{

    use SoftDeletes;

    protected $table = 'tb_ouvidoria_configuracao';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
