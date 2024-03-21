<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OuvidoriaAtendimento extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ouvidoria_atendimento';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];


    public function usuario(): BelongsTo
    {
        return $this->belongsTo(OuvidoriaUsuario::class, 'id_usuario');
    }
}
