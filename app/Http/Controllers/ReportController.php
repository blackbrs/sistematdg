<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semester;
use App\Tdg;
use App\College;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function principal_estados(){

        $semesterController = new SemesterController();

        return view('reportes.principal',  ['ciclos' => $semesterController->viewSemesters()]);
    }

    //Metodo para validar fechas de los ciclos seleccionados. 
    public function generar_reporteEstados(Request $request){

        //Obteniendo variables request
        $estado = $request['estado'];
        $periodo = $request['periodo'];

      
        if($estado=='Ingresado'){
            $estado=null;
        }
        $inicio = '';
        $fin = '';
        $ciclo = '';

        $mensaje='';
        $consulta='';

       
        //Dos ciclos
        if($periodo == 'mas_ciclo'){
             $inicio = $request['cicloInicio'];
            $fin = $request['cicloFin'];

            $cicloInicio = Semester::find($inicio);
            $cicloFin = Semester::find($fin);

            //Validamos que el ciclo fin sea mayor que el ciclo inicio.
            if($cicloInicio->fechaInicio > $cicloFin->fechaInicio){
                return response()->json([
                    'mensaje' => 'Error_ciclo',
                ]);
               }
               else{
                return response()->json([
                    'mensaje' => 'Ok',
                 ]);
               }
            
        }        
            
       

       
    }

    //Metodo que genera el reporte.
    public function pdfEstados(Request $request){
      
        //Obteniendo variables request
        $escuela = $request['escuela'];
        $estado = $request['estado'];
        $periodo = $request['periodo'];

        //Verificar si el reporte sera para todas las escuelas.
        if($estado=='Ingresado'){
            $estado=null;
        }
        $inicio = '';
        $fin = '';
        $ciclo = '';

        $mensaje='';
        $consulta='';
        $college='';

         //Dos ciclos
         if($periodo == 'mas_ciclo'){
            $inicio = $request['cicloInicio'];
           $fin = $request['cicloFin'];

           $cicloInicio = Semester::find($inicio);
           $cicloFin = Semester::find($fin);

           
              //Si las fechas estan bien
              $fechaInicio = date($cicloInicio->fechaInicio);
              $fechaFin = date($cicloFin->fechaInicio);
              if($escuela=='todas'){
               $consulta =Tdg::join('semesters', 'tdgs.ciclo_id', '=', 'semesters.id')
                          ->join('colleges', 'tdgs.escuela_id', '=', 'colleges.id')
                          ->select('tdgs.id', 'tdgs.codigo', 'tdgs.nombre', 'semesters.ciclo', 'colleges.nombre_completo as escuela')
                          ->where('semesters.fechaInicio','>=',$fechaInicio)
                          ->where('semesters.fechaInicio', '<=', $fechaFin)
                          ->where('tdgs.estado_oficial', '=',$estado)
                          ->orderBy('colleges.id')
                          ->orderBy('semesters.id')
                          ->get();
                          $college = 'Todas las escuelas';
              }else{
               $consulta =Tdg::join('semesters', 'tdgs.ciclo_id', '=', 'semesters.id')
                          ->join('colleges', 'tdgs.escuela_id', '=', 'colleges.id')
                          ->select('tdgs.id', 'tdgs.codigo', 'tdgs.nombre', 'semesters.ciclo', 'colleges.nombre_completo as escuela')
                          ->where('colleges.id', '=',$escuela)
                          ->where('semesters.fechaInicio','>=',$fechaInicio)
                          ->where('semesters.fechaInicio', '<=', $fechaFin)
                          ->where('tdgs.estado_oficial', '=',$estado)
                          ->orderBy('semesters.id')
                          ->get();

                          $college = College::find($escuela);
              }
              

           }else{

               //Un ciclo
               $id_ciclo = $request['ciclo'];
               $ciclo = Semester::find($id_ciclo);

               $fechaCiclo = date($ciclo->fechaInicio);

               if($escuela=='todas'){
                   $consulta =Tdg::join('semesters', 'tdgs.ciclo_id', '=', 'semesters.id')
                              ->join('colleges', 'tdgs.escuela_id', '=', 'colleges.id')
                              ->select('tdgs.id', 'tdgs.codigo', 'tdgs.nombre', 'semesters.ciclo', 'colleges.nombre_completo as escuela')
                              ->where('semesters.fechaInicio','=',$fechaCiclo)
                              ->where('tdgs.estado_oficial', '=',$estado)
                              ->orderBy('colleges.id')
                              ->get();

                              $college = 'Todas las escuelas';
                  }else{
                   $consulta =Tdg::join('semesters', 'tdgs.ciclo_id', '=', 'semesters.id')
                              ->join('colleges', 'tdgs.escuela_id', '=', 'colleges.id')
                              ->select('tdgs.id', 'tdgs.codigo', 'tdgs.nombre', 'semesters.ciclo', 'colleges.nombre_completo as escuela')
                              ->where('colleges.id', '=',$escuela)
                              ->where('semesters.fechaInicio','=',$fechaCiclo)  
                              ->where('tdgs.estado_oficial', '=',$estado)
                              ->get();

                              $college = College::find($escuela);
                  }
               

           }
           
           if($estado==null){
               $estado = 'Recién ingresado';
           }
          
            $titulo = 'Reporte de estado '.$estado;
            
           $date = Carbon::now();
           $fecha = $date->toFormattedDateString(); 

           $estadom = strtolower($estado);
           
        
           $pdf = PDF::loadView('reportes.estadosPdf', compact('consulta','titulo','college','fecha','estado'));

        return $pdf->download('Reporte_'.$fecha.'.pdf');


        //dd($escuela, $estado, $periodo);
       
    }

    public function principal_estados_escuela(){

        $semesterController = new SemesterController();

        return view('reportes.principal_escuela',  ['ciclos' => $semesterController->viewSemesters()]);
    }

    public function pdfEstadoEscuela(Request $request){
        
     
        
        //Obteniendo variables request
        $estado = $request['estado'];
        $periodo = $request['periodo'];

        //Obteniedo la escuela. 
        $escuela = Auth()->user()->college_id;

        //Verificar si el reporte sera para todas las escuelas.
        if($estado=='Ingresado'){
            $estado=null;
        }
        $inicio = '';
        $fin = '';
        $ciclo = '';

        $mensaje='';
        $consulta='';
        $college='';

         //Dos ciclos
         if($periodo == 'mas_ciclo'){
            $inicio = $request['cicloInicio'];
           $fin = $request['cicloFin'];

           $cicloInicio = Semester::find($inicio);
           $cicloFin = Semester::find($fin);

           
              //Si las fechas estan bien
              $fechaInicio = date($cicloInicio->fechaInicio);
              $fechaFin = date($cicloFin->fechaInicio);
             
               $consulta =Tdg::join('semesters', 'tdgs.ciclo_id', '=', 'semesters.id')
                          ->join('colleges', 'tdgs.escuela_id', '=', 'colleges.id')
                          ->select('tdgs.id', 'tdgs.codigo', 'tdgs.nombre', 'semesters.ciclo', 'colleges.nombre_completo as escuela')
                          ->where('colleges.id', '=',$escuela)
                          ->where('semesters.fechaInicio','>=',$fechaInicio)
                          ->where('semesters.fechaInicio', '<=', $fechaFin)
                          ->where('tdgs.estado_oficial', '=',$estado)
                          ->orderBy('semesters.id')
                          ->get();

                          $college = College::find($escuela);
              
              

           }else{

               //Un ciclo
               $id_ciclo = $request['ciclo'];
               $ciclo = Semester::find($id_ciclo);

               $fechaCiclo = date($ciclo->fechaInicio);

               
                   $consulta =Tdg::join('semesters', 'tdgs.ciclo_id', '=', 'semesters.id')
                              ->join('colleges', 'tdgs.escuela_id', '=', 'colleges.id')
                              ->select('tdgs.id', 'tdgs.codigo', 'tdgs.nombre', 'semesters.ciclo', 'colleges.nombre_completo as escuela')
                              ->where('colleges.id', '=',$escuela)
                              ->where('semesters.fechaInicio','=',$fechaCiclo)  
                              ->where('tdgs.estado_oficial', '=',$estado)
                              ->get();

                              $college = College::find($escuela);
                  
               

           }
           
           if($estado==null){
               $estado = 'Recién ingresado';
           }
          
            $titulo = 'Reporte de estado '.$estado;
            
           $date = Carbon::now();
           $fecha = $date->toFormattedDateString(); 

           $estadom = strtolower($estado);
           
        
           $pdf = PDF::loadView('reportes.estadosPdfEscuela', compact('consulta','titulo','college','fecha','estado'));

        return $pdf->download('Reporte_'.$fecha.'.pdf');
    }
}
