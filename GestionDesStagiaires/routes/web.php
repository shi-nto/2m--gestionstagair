<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EncadrantController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProlongationController;
use App\Http\Controllers\attestationController;
use App\Http\Controllers\fichesController;

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

Route::get('/',[UserController::class,'loginPage']);
Route::get('/login',[UserController::class,'loginPage']);
Route::post('/login',[UserController::class,'login'])->name('login');




Route::middleware(['auth'])->group(function () { 

Route::get('/prolongation',[ProlongationController::class,'index'])->name('prolongation');

Route::get('/ficheAttestation',[fichesController::class,'attestations'])->name('fiche.attestation');
Route::get('/ficheprolongation',[fichesController::class,'prolongations'])->name('fiche.prolongations');
Route::get('/ficheinitiale',[fichesController::class,'initiale'])->name('fiche.initiale');
Route::delete('fiche/{id}',[fichesController::class,'delete'])->name('fiche.delete');


Route::match(['get','post'],'ficheSearchA',[fichesController::class,'searchA'])->name('fiche.searchA');
Route::match(['get','post'],'ficheSearchP',[fichesController::class,'searchP'])->name('fiche.searchP');
Route::match(['get','post'],'ficheSearchI',[fichesController::class,'searchI'])->name('fiche.searchI');

Route::get('editProlong/{id}',[ProlongationController::class,'edit'])->name('editPro');
Route::put('updateProl',[ProlongationController::class,'update'])->name('updateProl');

Route::get('/home',[UserController::class,'index'])->name("home");

Route::get('/logout',[UserController::class,'logout'])->name('logout');

Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
Route::get('/nature',[StatisticsController::class,'nature'])->name('nature');
Route::get('/gender',[StatisticsController::class,'gender'])->name('gender');
Route::get('/depart',[StatisticsController::class,'depart'])->name('depart');
Route::get('/year',[StatisticsController::class,'year'])->name('year');
Route::get('/moisA',[StatisticsController::class,'moisA'])->name('moisA');
Route::get('/enc',[StatisticsController::class,'enc'])->name('enc');


Route::get('/addInternForm',[StagiaireController::class,'addInternForm'])->name('addInternForm');

Route::post('/addIntern',[StagiaireController::class,'addIntern'])->name('addIntern');


Route::get('/search', [StagiaireController::class, 'search'])->name('search');
Route::post('/search', [StagiaireController::class, 'search'])->name('search.search');


Route::put('/intUpdate',[StagiaireController::class,'update'])->name('intUpdate');


Route::get('/admin/intedit/{id}',[StagiaireController::class, 'edit']);


Route::get('/proSearch', [ProlongationController::class, 'search'])->name('proSearch');
Route::post('/proSearch', [ProlongationController::class, 'search'])->name('proSearch.search');

Route::get('/prolonger/{id}', [ProlongationController::class, 'prolongerView'])->name('prolonger');
Route::post('/prolonge',[ProlongationController::class, 'prolonger'])->name('prolonge');

Route::get('/ficheInitiale/{id}',[StagiaireController::class,'ficheInitiale'])->name('ficheInitiale');
Route::get('/admin/monthlyData/{year}', [StatisticsController::class, 'getMonthlyData'])->name('statistics.monthlyData');
Route::get('/admin/encadrantData/{encadrantId}/{year}', [StatisticsController::class, 'getInternsByEncadrantAndYear'])->name('admin.encadrantData');
// Route to get interns by department for a selected year
Route::get('/admin/internsByDepartment/{year}', [StatisticsController::class, 'getInternsByDepartment'])->name('internsByDepartment');
// Route to get interns by gender for a selected year
Route::get('/admin/internsByGender/{year}', [StatisticsController::class, 'getInternsByGender'])->name('internsByGender');
Route::get('/admin/internsByNatureStage/{year}', [StatisticsController::class, 'getInternsByNatureStage']);
Route::get('/ficheProlongation/{id}',[ProlongationController::class, 'ficheProlongation']);
Route::get('/attestation/{id}',[attestationController::class,'attestation']);

Route::middleware(['role:1'])->group(function () {

    Route::post('/addUser',[UserController::class,'addUser'])->name('addUser');

Route::post('/addDep',[DepartementController::class,'addDep'])->name('addDep');

Route::post('/addEnc',[EncadrantController::class,'addEnc'])->name('addEnc');


    Route::delete('dep/delete/{id}',[DepartementController::class,'delete'])->name('dep.delete');

    Route::delete('enc/delete/{id}',[EncadrantController::class,'delete'])->name('enc.delete');
    
    Route::delete('int/delete/{id}',[StagiaireController::class,'delete'])->name('int.delete');
    
    Route::delete('pro/delete/{id}',[ProlongationController::class,'delete'])->name('pro.delete');
    
    Route::delete('user/delete/{id}',[UserController::class,'delete'])->name('user.delete');
    
    Route::post('/depUpdate',[DepartementController::class,'update'])->name('depUpdate');
    
    Route::post('/encUpdate',[EncadrantController::class,'update'])->name('encUpdate');

    Route::put('/userUpdate/{id}',[UserController::class,'update'])->name('userUpdate');

    Route::get('/depSearch', [DepartementController::class, 'search'])->name('depSearch');
    Route::post('/depSearch', [DepartementController::class, 'search'])->name('depSearch.search');

    Route::get('/encSearch', [EncadrantController::class, 'search'])->name('encSearch');
    Route::post('/encSearch', [EncadrantController::class, 'search'])->name('encSearch.search');

    Route::get('/userSearch', [UserController::class, 'search'])->name('userSearch');
    Route::post('/userSearch', [UserController::class, 'search'])->name('userSearch.search');

});

Route::get('/admin/{action}/{id?}', function ($action,$id=null) {
        // Check if the authenticated user is an admin (type === 1)
        if (auth()->check() && auth()->user()->role === 1) {
            switch ($action) {
                case 'addUserForm' : 
                    return app(UserController::class)->addUserForm();
                case 'addEnc' : 
                        return app(UserController::class)->addEncForm();
                case 'addDepForm':
                    return app(DepartementController::class)->addDepForm();
                case 'addEncForm' : 
                    return app(EncadrantController::class)->addEncForm();
                case 'departement':
                    return app(DepartementController::class)->index();
                case 'depedit':
                    return app(DepartementController::class)->edit($id);
                case 'encedit':
                        return app(EncadrantController::class)->edit($id);
              
                case 'useredit' : 
                            return app(UserController::class)->edit($id);
                case 'users' : 
                    return app(UserController::class)->lister();
                case 'encadrant' :
                    return app(EncadrantController::class)->index();
                case 'deletedDep' : 
                    return app(DepartementController::class)->deletedDep(); 

                case 'depRestore' : 
                    return app(DepartementController::class)->restore($id);  
                case 'deletedEnc' : 
                        return app(EncadrantController::class)->deletedEnc();    
                
                case 'encRestore' : 
                            return app(EncadrantController::class)->restore($id);      
                default:
                    abort(404);
            }
        } else {
            abort(403, 'Unauthorized action.');
        }
    })->name('admin');

});
