<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    //
    //
    protected $table = 'tipoevento';
    protected $fillable = [
        'tipo',
        'color',
        'textColor'
    ];
}
