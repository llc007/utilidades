<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    //
    //
    protected $table = 'eventos';
    protected $fillable =
        [
            'title',
            'description',
            'textColor',
            'color',
            'start',
            'end',
            'tipoevento'
        ];
    public function tipo()
    {
        return $this->hasOne('App\TipoEvento');
    }
}
