<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OuvidoriaAtendimento extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ouvidoria_atendimento';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    // BelongsTo -> Pertence a um
    // BelongsToMany -> Pertence a muitos
    // HasOne -> Tem um
    // HasMany -> Tem muitos


    public function usuario(): BelongsTo
    {
        return $this->belongsTo(OuvidoriaUsuario::class, 'id_usuario');
    }

    public function mensagens(): HasMany
    {
        return $this->hasMany(OuvidoriaMensagem::class, 'id_atendimento');
    }
}
