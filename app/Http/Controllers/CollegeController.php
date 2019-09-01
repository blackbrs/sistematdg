<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;

class CollegeController extends Controller
{
    // Está función se consulta mediante ajax para traer las escuelas
    public function allNameColleges(){

        // Realizar consultas a la base de datos
        $colleges = DB::table('users')
            ->select('college_id as id', 'username as escuela')
            ->whereNotNull('college_id')
            ->get();

        return $colleges;
    }
}
