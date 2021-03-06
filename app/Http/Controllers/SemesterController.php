<?php

namespace App\Http\Controllers;
use App\Semester;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    //
    public function create()
    {
        $semesters = DB::table('semesters')
            ->orderBy('fechaInicio', 'desc')
            ->get();
        return view('semester.ingresar', ['semesters' => $semesters]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ciclo'=>'required|in:I,II',
            'fechaInicio'=>'required',
        ]);

        $fechaInicio = $data['fechaInicio'];

        //Extracion de la fecha para poder validar que el inicio del ciclo siempre se cree en el año en curso
        $fechaEntera = strtotime($fechaInicio);
        $anio = date("Y", $fechaEntera);

        //Se obtiene el año actual del sistema
        $anioActual = date("Y");

        if($anioActual == $anio || ($anioActual-1) == $anio)
        {
            $ciclo = $data['ciclo']."-".$anio;
            
            $semestre=Semester::create([
                'ciclo'=>$ciclo,
                'fechaInicio'=>$fechaInicio,
            ]);
            return redirect()->route('semester.ingresar', 'save=1');
        }
        else{
            $mensaje = 'Fecha no válida.';
            return redirect()->route('semester.ingresar', 'save=0&mensaje='.$mensaje);
        }
    }

    // Función para obtener de la base de datos los ciclos en el periodo del año actual y el anterior
    public function viewSemesters()
    {
        $anioActual = date('Y');
        $fechaMinima = ($anioActual -1).'-01-01';
        $fechaMaxima = $anioActual.'-12-31';

        $ciclos = DB::table('semesters')
            ->select('id', 'ciclo')
            ->whereBetween('fechaInicio', [$fechaMinima, $fechaMaxima])->get();

        return $ciclos;
    }

    public function lastSemester()
    {
        $fechaActual = date('Y-m');
        $anioActual = date('Y');

        //Para el primer ciclo
        if($fechaActual >= $anioActual.'-02' && $fechaActual <= $anioActual.'-07'){

            $fechaMinima = $anioActual.'-02-01';
            $fechaMaxima = $anioActual.'-03-31';
            $ciclo = DB::table('semesters')
            ->select('id', 'ciclo')
            ->whereBetween('fechaInicio', [$fechaMinima, $fechaMaxima])->get(); 
        }else{
            //Para el segundo ciclo
            $fechaMinima = $anioActual.'-08-01';
            $fechaMaxima = $anioActual.'-09-30';

            $ciclo = DB::table('semesters')
            ->select('id', 'ciclo')
            ->whereBetween('fechaInicio', [$fechaMinima, $fechaMaxima])->get();

        }
        return $ciclo;

    }
}
