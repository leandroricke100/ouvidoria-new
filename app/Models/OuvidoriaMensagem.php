<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvidoriaMensagem extends Model
{

    use SoftDeletes;

    protected $table = 'tb_ouvidoria_mensagem';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function atendimento()
    {
        return $this->belongsTo(OuvidoriaAtendimento::class, 'id_atendimento');
    }

}
