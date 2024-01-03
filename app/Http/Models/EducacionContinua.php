<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;


class EducacionContinua extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'educacioncontinua';


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
        'ubicacion_id',
        'escuela_id',
        'periodo_id',
        'tipoprograma_id',
        'ecClave',
        'ecNombre',
        'ecFechaRegistro',
        'ecCoordinador_empleado_id',
        'ecInstructor1_empleado_id',
        'ecInstructor2_empleado_id',
        'ecEstado',
        'ecImporteInscripcion',
        'ecVencimientoInscripcion',
        'ecImportePago1',
        'ecVencimientoPago1',
        'ecImportePago2',
        'ecVencimientoPago2',
        'ecImportePago3',
        'ecVencimientoPago3',
        'ecImportePago4',
        'ecVencimientoPago4',
        'ecImportePago5',
        'ecVencimientoPago5',
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
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);
        });
    }
   }


   public function ubicacion()
   {
      return $this->belongsTo(Ubicacion::class);
   }

   public function escuela()
   {
      return $this->belongsTo(Escuela::class);
   }

   public function periodo()
   {
      return $this->belongsTo(Periodo::class);
   }

   public function empleado()
   {
      return $this->belongsTo(Empleado::class);
   }

    public function tipoprograma()
    {
       return $this->belongsTo(TiposPrograma::class);
    }
}