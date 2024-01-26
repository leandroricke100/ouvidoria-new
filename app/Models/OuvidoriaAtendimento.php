<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OuvidoriaAtendimento extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ouvidoria_atendimento';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
