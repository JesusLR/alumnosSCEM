<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class MiCuentaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');

    }

    public function index()
    {
        return view('miCuenta.cuenta');
    }
    
    public function cambiarPassword(Request $request)
    {


        $user = User::find(auth()->user()->id);


        $validator = Validator::make($request->all(), [
              'nuevo_password'          =>  'required|max:20',
              'nuevo_confirmPassword'   =>  'required|same:nuevo_password',
          ], [
              'nuevo_confirmPassword.same'     => 'Ambos campos de contraseña deben coincidir.',
              'nuevo_password.required'        => 'La contraseña nueva es requerida.',
              'nuevo_confirmPassword.required' => 'La contraseña de verificación es requerida.'
          ]);
          
    
    
        if ($validator->fails()) {
          return redirect()->back()->withErrors($validator);
        }
    
    
        if($request->antiguoPassword != $user->password){
            alert('Escuela Modelo', 'Tu contraseña actual no coincide', 'warning')->showConfirmButton();
            return redirect()->back();
        }
    
            
        DB::update("UPDATE users_alumnos SET password='".$request->nuevo_password."' WHERE id=$user->id");
        
        alert('Escuela Modelo', 'Contraseña guardada correctamente', 'success')->showConfirmButton();
        return redirect()->back();
    }

    
}
