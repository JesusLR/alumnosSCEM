<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Historico extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'historico';


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
        'curso_id',
        'grupo_id',
        'alumno_id',
        'plan_id',
        'materia_id',
        'periodo_id',
        'histComplementoNombre',
        'histPeriodoAcreditacion',
        'histTipoAcreditacion',
        'histFechaExamen',
        'histCalificacion',
        'histFolio',
        'hisActa',
        'histLibro',
        'histNombreOficial'
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
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
          if ($table->calificacion) {
            $table->usuario_at = Auth::user()->id;
            $table->calificacion->delete();
          }
        });
      }
   }

    public function alumno()
    {
      return $this->belongsTo(Alumno::class);
    }

    public function plan()
    {
      return $this->belongsTo(Plan::class);
    }

    public function materia()
    {
      return $this->belongsTo(Materia::class);
    }

    public function periodo()
    {
      return $this->belongsTo(Periodo::class);
    }

    public function inscrito(){
      return $this->hasOne(Inscrito::class);
    }

}