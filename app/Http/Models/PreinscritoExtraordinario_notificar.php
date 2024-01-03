<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class PreinscritoExtraordinario_notificar extends Model
{
    //
	use SoftDeletes;

	protected $table = 'preinscritosextraordinarios_notificar';

	protected $fillable = [
		'aluClave',
		'aluCorreo',
		'aluCelular'
	];

	protected $dates = [
		'deleted_at'
	];


	/**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
   protected static function boot()
   {
     parent::boot();
     if(Auth::check()){
        static::saving(function($table) {
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            $table->usuario_at = Auth::user()->id;
        });
    }
   }


}
