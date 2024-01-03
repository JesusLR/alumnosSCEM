<?php

namespace App\Http\Models\Primaria;

use App\Http\Models\Curso;
use App\Http\Models\Plan;
use App\Http\Models\Primaria\Primaria_grupo;
use App\Http\Models\Primaria\Primaria_calificacione;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_inscrito extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'primaria_inscritos';


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
          'primaria_grupo_id',
          'inscCalificacionSep',
          'inscCalificacionOct',
          'inscCalificacionNov',
          'inscCalificacionDic',
          'inscCalificacionEne',
          'inscCalificacionFeb',
          'inscCalificacionMar',
          'inscCalificacionAbr',
          'inscCalificacionMay',
          'inscCalificacionJun',
          'inscPromedioMes',
          'inscBimestre1',
          'inscBimestre2',
          'inscBimestre3',
          'inscBimestre4',
          'inscBimestre5',
          'inscPromedioBim',
          'inscTipoAsistencia',
          'inscEmpleadoIdDocente'
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

        // static::deleting(function($table) {
        //     $table->usuario_at = Auth::user()->id;
        //     $table->preescolar_calificacion->delete();
        // });
    }
   }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function primaria_grupo()
    {
        return $this->belongsTo(Primaria_grupo::class, "primaria_grupo_id");
    }

    public function primaria_calificacion()
    {
        return $this->hasOne(Primaria_calificacione::class);
    }

    public function primaria_empleado()
    {
        return $this->belongsTo(Primaria_empleado::class, 'inscEmpleadoIdDocente');
    }

}
