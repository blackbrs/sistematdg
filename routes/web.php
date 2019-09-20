<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/ingresar/ciclo', 'SemesterController@create')->name('semester.ingresar');
Route::post('/guardar/ciclo', 'SemesterController@store')->name('semester.guardar');

Route::middleware(['auth'])->group(function(){
//Rutas para acuerdos
Route::get('/ingresar/acuerdos', 'AgreementController@create')->name('agreement.ingresar')->middleware('can:agreement.ingresar');
Route::post('/guardar/acuerdos', 'AgreementController@store')->name('agreement.guardar')->middleware('can:agreement.guardar');

//Rutas para trabajos de graduacion
Route::get('/ingresar/tdg', 'TdgController@create')->name('tdg.ingresar')->middleware('can:tdg.ingresar');
Route::post('/guardar/tdg', 'TdgController@store')->name('tdg.guardar')->middleware('can:tdg.guardar');

// Ruta para traer todos los docentes para asignación de tribunal
Route::get('/todos/profesores/nombramiento/tribunal', 'ProfessorController@allProfessorNombramientoTribunal')->name('professor.todosProfesoresNombramientoTribunal');


// Ruta para para enviar todos los datos del TDG para filtro de solicitudes
Route::get('/todos/tdg/solicitudes', 'TdgController@allTdgSolicitudes')->name('tdg.todosTdgSolicitudes');
// Ruta para para enviar todos los datos del TDG para filtro de asignaciones de docente, estudiantes y asesores
Route::get('/todos/tdg/asignaciones', 'TdgController@allTdgAsignaciones')->name('tdg.todosTdgAsignaciones');


//Ruta para la creacion del ciclo
Route::get('/ingresar/ciclo', 'SemesterController@create')->name('semester.ingresar')->middleware('can:semester.ingresar');
Route::post('/guardar/ciclo', 'SemesterController@store')->name('semester.guardar')->middleware('can:semester.ingresar');

//Rutas para importar los estudiantes por medio de un excel
Route::get('/ingresar/estudiantes', 'StudentController@create')->name('student.ingresar')->middleware('can:student.ingresar');
Route::post('/guardar/estudiantes', 'StudentController@store')->name('student.guardar')->middleware('can:student.guardar');

//Rutas para importar los maestros y el formulario de profesores.accordion
Route::get('/ingresar/profesores', 'ProfessorController@create')->name('professor.ingresar')->middleware('can:professor.ingresar');
Route::post('/guardar/profesores', 'ProfessorController@store')->name('professor.guardar')->middleware('can:professor.guardar');
Route::post('/guardar/excel/profesores', 'ProfessorController@storexls')->name('professor.guardarexcel')->middleware('can:professor.guardarexcel');

// Pantalla mostrar filtros de TDG para solicitudes
Route::get('/listar/tdg/solicitudes', function () {
    return view('requests.filtro');
})->name('solicitudes.listar');

//Rutas para las solicitudes
Route::get('/ingresar/solicitud/nombre/{id}', 'RequestNameController@create')->name('request_name.ingresar');
Route::post('/guardar/solicitud/nombre', 'RequestNameController@store')->name('name.guardar');

Route::get('/ingresar/solicitud/tribunal/{id}', 'RequestTribunalController@create')->name('request_tribunal.ingresar');
Route::get('/guardar/solicitud/tribunal', 'RequestTribunalController@store')->name('request_tribunal.guardar');
Route::get('/guardar/tribunal/profesor', 'RequestTribunalController@storeRequestTribunalProfessor')->name('request_tribunal.guardarRequestTribunalProfessor');

Route::get('/ingresar/solicitud/{tipo_solicitud}/{id}', 'RequestExtensionController@create')->name('request_extension.ingresar');
Route::post('/guardar/solicitud/prorroga', 'RequestExtensionController@store')->name('request_extension.guardar');

Route::get('/ingresar/solicitud/{id}', 'RequestResultController@create')->name('request_result.ingresar');
Route::post('/guardar/solicitud/', 'RequestResultController@store')->name('request_result.guardar');

// Pantalla mostrar filtros de TDG para solicitudes
Route::get('/listar/tdg/asignar', function () {
    return view('assignments.filtro');
});

// Ruta para todos los nombres de las escuelas
Route::get('/todos/colleges', 'CollegeController@allNameColleges')->name('colllege.todos');

});
// Pantalla para mostrar los filtros y mostrar los acuerdos de junta directiva
Route::get('/listar/acuerdos/jd', function(){
    return view('agreement.listar_acuerdos');
});

Route::get('/todos/acuerdos/ver/jd', 'AgreementController@allJdAcuerdos')->name('agreement.show');
