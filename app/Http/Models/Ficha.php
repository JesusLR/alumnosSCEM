<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Ficha extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fichas';


    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fchNumPer',
        'fchAnioPer',
        'fchClaveAlu',
        'fchClaveCarr',
        'fchClaveProgAct',
        'fchGradoSem',
        'fchGrupo',
        'fchFechaImpr',
        'fchHoraImpr',
        'fchUsuaImpr',
        'fchTipo',
        'fchConc',
        'fchFechaVenc1',
        'fhcImp1',
        'fhcRef1',
        'fchFechaVenc2',
        'fhcImp2',
        'fhcRef2',
        'fchEstado',
        'usuario_at'
    ];

    protected $dates = [
        'deleted_at',
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
            $table->usuario_at = 145;//Auth::user()->id;
        });

        static::updating(function($table) {
            $table->usuario_at = 145;//Auth::user()->id;
        });

        static::deleting(function($table) {
            $table->usuario_at = 145;//Auth::user()->id;
        });
    }
   }

   public function usuario() {
    return $this->belongsTo('App\Models\User', 'usuario_at');
   }
   public function alumno() {
    return $this->belongsTo(Alumno::class, 'fchClaveAlu', 'aluClave');
   }

}