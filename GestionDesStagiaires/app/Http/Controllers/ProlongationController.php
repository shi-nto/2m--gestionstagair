<?php

namespace App\Http\Controllers;
use App\Models\prolongation;
use App\Models\stagiaires;
use App\Models\encadrants;
use App\Models\departements;
use App\Models\personnel;


use App\Models\fiches;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ProlongationController extends Controller
{
    //
    public function index(){
        $data = prolongation::orderBy('id_stag')
        ->orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(10);
    
        return view('user.prolongation',compact('data'))->render();
    }

    public function delete($id){
        $e=prolongation::findOrFail($id);
        $e->delete();
        return redirect("/prolongation")->with("success","deleted successfully");
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        
        $query = prolongation::join('stagiaires', 'prolongation.id_stag', '=', 'stagiaires.id')
            ->select('prolongation.*');
        


        switch ($category) {
            case 'numero':
                $query->where('stagiaires.id', 'like',  $search );
                break;
            case 'nom':
                $query->where('stagiaires.nom', 'like', $search );
                break;
            case 'prenom':
                $query->where('stagiaires.prenom', 'like',  $search );
                break;
            case 'cin':
                $query->where('stagiaires.cin', 'like',  $search );
                break;
            case 'date_debut':
                $query->where('prolongation.date_debut', 'like', '%' . $search . '%');
                break;
            case 'old_date_fin':
                $query->where('prolongation.old_date_fin', 'like', '%' . $search . '%');
                break;
         
        }
    
        $data = $query->paginate(10);
  
            return view('user.prolongation', compact('data', 'search'))->render();;
        
    }

    public function prolongerView($id){
        $data = stagiaires::findOrFail($id);
        $departements=DepartementController::All();
        $encadrants=EncadrantController::All();
        return view("user.prolonger",compact('data','departements','encadrants'));
    }

    public function prolonger(Request $request){
       
        if($request->id_pers != null ){
            $p = personnel::create([
                'id_enc' => $request->id_pers,
            ]);
            $id_pers = $p->id;
        }
        else { 
            $id_pers = null ; 
        }

        $p=prolongation::create([
            'id_stag' => $request->id_stag, // Ensure this is the correct field name
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'motif' => $request->motif,
            'old_date_fin' => $request->date_fin_old,
            'id_enc' => $request->id_enc,
            'id_pers' =>  $id_pers ,
            'old_pers' =>   $request->old_pers,
            'old_enc' =>   $request->old_enc,
        ]);
        return  redirect('/prolongation')->with('success','Prolonger avec success');
    }
    public function ficheProlongation($id){
        
        $data = prolongation::findOrFail($id);
     
        if($data){
            Carbon::setLocale('fr');
            $dateDebut = \Carbon\Carbon::parse($data->stagiaire->date_debut);
            $moisD = strtoupper($dateDebut->translatedFormat('F'));
            $anneeD = $dateDebut->year;
            $jourD = $dateDebut->day;

            $dateFin = \Carbon\Carbon::parse($data->stagiaire->date_fin);
            $moisF = strtoupper($dateFin->translatedFormat('F'));
            $anneeF = $dateFin->year;
            $jourF = $dateFin->day;


            
            $dateFinN = \Carbon\Carbon::parse($data->date_fin);
            $moisFN = strtoupper($dateFinN->translatedFormat('F'));
            $anneeFN = $dateFinN->year;
            $jourFN = $dateFinN->day;

            if ($moisF == "AOûT") {
                $moisF = "AOUT";
            } 
            if ($moisD == "AOûT") {
                $moisD = "AOUT";
            }
            if ($moisFN == "AOûT") {
                $moisFN = "AOUT";
            }
             // Create directory path
            $directoryPath = storage_path("app/public/fiche/FicheProlongation/$anneeD/$moisD");

            // Check if the directory exists, if not create it
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }


            $templateProcessor = new TemplateProcessor(storage_path('app/public/fiche/prolongation.docx'));
            $templateProcessor->setValue('departement', $data->stagiaire->encadrant->departement->nom);
            $templateProcessor->setValue('full_name', $data->stagiaire->nom ." ".$data->stagiaire->prenom);
            $templateProcessor->setValue('school', $data->stagiaire->institut);
            if($data->stagiaire->nature_stage == 'aplication') 
            $nature = "Application";
            else if($data->stagiaire->nature_stage == 'observation')
            $nature = 'Observation';
            else 
            $nature = "Fin d'études";
            $templateProcessor->setValue('nature_stage', $nature);

            $templateProcessor->setValue('dayD', $jourD);
            $templateProcessor->setValue('yearD', $anneeD);
            $templateProcessor->setValue('monthD', $moisD);

            $templateProcessor->setValue('dayF', $jourF);
            $templateProcessor->setValue('yearF', $anneeF);
            $templateProcessor->setValue('monthF', $moisF);

            $templateProcessor->setValue('schooll', $data->stagiaire->institut);
            
            $templateProcessor->setValue('theme', $data->stagiaire->theme);
            $start_date = \Carbon\Carbon::parse($data->date_debut);
            $end_date = \Carbon\Carbon::parse($data->old_date_fin);
            $diff = $start_date->diff($end_date);
            
            // Get the total number of days
            $totalDays = $diff->days;
            $years = $diff->y;
            $months = $diff->m;
            $weeks = intdiv($totalDays, 7);
            $days = $totalDays % 7;
            
            // Build the formatted string
            $formattedDiff = '';
            
            // Add years if greater than 0
            if ($years > 0) {
                $formattedDiff .= $years . ' Année' . ($years > 1 ? 's' : '') . ' ';
            }
            
            // Convert weeks to months if more than 4
            if ($weeks >= 4) {
                $monthsFromWeeks = intdiv($weeks, 4); // Approximate months from weeks
                $weeks = $weeks % 4;
                $months += $monthsFromWeeks; // Add months derived from weeks
            }
            
            // Add months if greater than 0
            if ($months > 0) {
                $formattedDiff .= $months . ' moi' . ($months > 1 ? 's' : '') . ' ';
            }
            
            // Add weeks if greater than 0
            if ($weeks > 0) {
                $formattedDiff .= $weeks . ' semaine' . ($weeks > 1 ? 's' : '') . ' ';
            }
            
            // Add days if greater than 0
            if ($days > 0) {
                $formattedDiff .= $days . ' jour' . ($days > 1 ? 's' : '');
            }
            
            // Trim trailing spaces
            $formattedDiff = trim($formattedDiff);
            
            // Set the formatted string in the template
            $templateProcessor->setValue('periode', $formattedDiff);
             
            $templateProcessor->setValue('encadrant', $data->stagiaire->encadrant->nom ." ".$data->stagiaire->encadrant->prenom);
            $templateProcessor->setValue('dayFO', $jourF);
            $templateProcessor->setValue('yearFO', $anneeF);
            $templateProcessor->setValue('monthFO', $moisF);
                      
            $templateProcessor->setValue('dayFN', $jourFN);
            $templateProcessor->setValue('yearFN', $anneeFN);
            $templateProcessor->setValue('monthFN', $moisFN);
            
            $templateProcessor->setValue('motif', $data->motif);

            $outputPath = "$directoryPath/fiche_de_prolongation_{$data->stagiaire->nom}_{$data->stagiaire->prenom}_{$anneeD}_{$moisD}.docx";
            $templateProcessor->saveAs($outputPath);
    
            $exist = fiches::where("path",'=',$outputPath)->exists();
            if($exist) {}
            else {
            $fiche = fiches::create([
                'path'=> $outputPath,
                'nom'=> $data->stagiaire->nom.' '.$data->stagiaire->prenom,
                'annee'=>$anneeD,
                'mois'=>$moisD,
                'nombre'=> $data->id,
                'type'=> 2
            ]);}

            // Optionally, download the document
            return response()->download($outputPath)->deleteFileAfterSend(false);

        }
        else 
        {
            return back()->with('error','Un erreur est survenue');
        }
    
    }
    public function edit($id){
        $data = prolongation::findOrFail($id);
        $encadrants = encadrants::all();
        $departements = departements::all();

        return view('user.editProlongation',compact('data','encadrants','departements'));
    }
    public function update(Request $request){
        $data = prolongation::findOrFail($request->id);
        if($request->id_enc != null )
        $data->id_enc = $request->id_enc;

        if($request->id_pers != null){
            if($data->id_pers != null ){
                    $pers = personnel::findOrFail($data->id_pers);
                    $pers->id_enc = $request->id_pers;
                    $pers->save();
            } else {
            $pers = personnel::create([
                'id_enc' =>$request->id_pers
            ]);
            $data->id_pers = $pers->id;
        }
        }
     

        if($request->motif != null)
        $data->motif = $request->motif;

        $data->date_fin = $request->date_fin;
        $data->save();
        return redirect('/prolongation')->with('success','Modifié avec success');

        } 
}
