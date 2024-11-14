<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\stagiaires;
use App\Models\fiches;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EncadrantController;
use App\Http\Controllers\personnelsController;
use App\Models\personnel;
use App\Models\prolongation;
use PhpOffice\PhpWord\TemplateProcessor;

class StagiaireController extends Controller
{
    //

    public function search(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        
        $query = Stagiaires::join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
            ->join('departements', 'encadrants.id_dep', '=', 'departements.id') // Assuming encadrants table has a foreign key id_dep referencing departements
            ->select('stagiaires.*');
        
        switch ($category) {
            case 'numero':
                $query->where('stagiaires.id', 'like',  $search  );
                break;
            case 'nom':
                $query->where('stagiaires.nom', 'like','%' . $search . '%' );
                break;
            case 'prenom':
                $query->where('stagiaires.prenom', 'like', '%' . $search . '%' );
                break;
            case 'cin':
                $query->where('stagiaires.cin', 'like',  $search );
                break;
            case 'date_debut':
                $query->where('stagiaires.date_debut', 'like', '%' . $search . '%');
                break;
            case 'date_fin':
                $query->where('stagiaires.date_fin', 'like', '%' . $search . '%');
                break;
            case 'insitut':
                $query->where('stagiaires.institut', 'like', '%' . $search . '%');
                break;
            case 'nature':
                $query->where('stagiaires.nature_stage', 'like', '%' . $search . '%');
                break;
            case 'dep':
                $query->where('departements.nom', 'like', '%' . $search . '%');
                break;
            default:
                // Handle the default case or an invalid category
                // You can choose to return all posts or show an error
                $query->where('stagiaires.nom', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.prenom', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.cin', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.institut', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.formation', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.gsm', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.nature_stage', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.theme', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.date_debut', 'like', '%' . $search . '%')
                    ->orWhere('stagiaires.date_fin', 'like', '%' . $search . '%')
                    ->orWhere('departements.nom', 'like', '%' . $search . '%');
                break;
        }
    
        $posts = $query->paginate(10);
    
        if ($request->ajax()) {
            return view('user._stagiaire', compact('posts'))->render();
        } else {
            return view('user.home', compact('posts', 'search'));
        }
    }
    
    
    public function addInternForm(){
        $departements=DepartementController::All();
        $encadrants=EncadrantController::All();
        return view('user.addIntForm',compact('departements','encadrants'));
    }
    public function addIntern(Request $request)
    {
        $input = $request->only(
            'nom', 
            'prenom',  
            'institut', 
            'formation', 
            'gsm', 
            'nature_stage', 
            'theme', 
            'date_debut', 
            'date_fin', 
            'id_dep', 
            'id_enc',
            'id_pers',
            'gender'
        );
    if($input['id_dep']==null ||$input['id_enc']==null ||$input['id_pers']==null )
    {
        return back()->withInput()->with("error", "veuillez selectionner un departement");
    }
        // Check for overlapping dates for the same intern (same CIN)
       
    
        // Create a new Personnel entry
        $personnel = personnel::create(['id_enc' => $input['id_pers']]);
        
        // Create a new Stagiaire entry
        $stagiaire = stagiaires::create([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'institut' => $input['institut'],
            'formation' => $input['formation'],
            'gsm' => $input['gsm'],
            'nature_stage' => $input['nature_stage'],
            'theme' => $input['theme'],
            'date_debut' => $input['date_debut'],
            'date_fin' => $input['date_fin'],
            'id_pers' => $personnel->id,
            'id_enc' => $input['id_enc'],
            'gender' => $input['gender'],
        ]);
    
        // Redirect to the addInternForm route
        return redirect('/home')->with('success', 'Stagiaire ajouté'); 
        
    }
    

    public function delete($id){
        $e=stagiaires::findOrFail($id);
        $p=personnel::findOrFail($e->id_pers);
        $e->delete();
        $p->delete();
       
        return redirect("/home")->with("success","deleted successfully");
    }
    public function edit($id){
        $data=stagiaires::with('encadrant.departement')->findOrFail($id);
        $departements=DepartementController::All();
        $encadrants=EncadrantController::All();
        return view("admin.intEdit",compact('data','departements','encadrants'));
    }

  
    public function update(Request $request)
    {
        
        // Find the stagiaire by ID
        $stag = stagiaires::findOrFail($request->id);
    

      
    
        if ($stag->date_debut != $request->date_debut) {
            $prolongations = prolongation::where("id_stag", $request->id)->get(); // Retrieve all matching records
            foreach ($prolongations as $per) {
                $per->date_debut = $request->date_debut;
                $per->save();
            }
        }
        if ($stag->date_fin != $request->date_fin) {
            $prolongations = prolongation::where("id_stag", $request->id)->get(); // Retrieve all matching records
            foreach ($prolongations as $per) {
                $per->old_date_fin = $request->date_fin;
                $per->save();
            }
        }
        
        

      
            $per = personnel::findOrFail($request->id_pers);
            $per->id_enc = $request->id_pers1;
            $per->save();
    
            $stag->id_pers = $per->id;
        
    
        $stag->nom = $request->nom;
        $stag->prenom = $request->prenom;
        $stag->gender = $request->gender;
        $stag->institut = $request->institut;
        $stag->formation = $request->formation;
        $stag->gsm = $request->gsm;
        $stag->nature_stage = $request->nature_stage;
        $stag->theme = $request->theme;
        $stag->id_enc = $request->id_enc;
        $stag->date_debut = $request->date_debut;
        $stag->date_fin = $request->date_fin;
        $stag->save();
      
        return redirect('/home')->with('success', 'Updated successfully');
    }
        
    public function ficheInitiale($id){
        $data = stagiaires::findOrFail($id);
     
        if($data){
            Carbon::setLocale('fr');
            $dateDebut = \Carbon\Carbon::parse($data->date_debut);
            $moisD = strtoupper($dateDebut->translatedFormat('F')); // e.g., "AUGUST"
            $anneeD = $dateDebut->year;
            $jourD = $dateDebut->day;

            $dateFin = \Carbon\Carbon::parse($data->date_fin);
            $moisF = strtoupper($dateFin->translatedFormat('F'));
            $anneeF = $dateFin->year;
            $jourF = $dateFin->day;
             // Create directory path
            $directoryPath = storage_path("app/public/fiche/FicheInitiale/$anneeD/$moisD");

            if ($moisF == "AOûT") {
                $moisF = "AOUT";
            }
            if ($moisD == "AOûT") {
                $moisD = "AOUT";
            }
            // Check if the directory exists, if not create it
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }
            $templateProcessor = new TemplateProcessor(storage_path('app/public/fiche/FICHE_DE_STAGE.docx'));
            $templateProcessor->setValue('departement', $data->encadrant->departement->nom);
            $templateProcessor->setValue('full_name', $data->nom ." ".$data->prenom);
            $templateProcessor->setValue('school', $data->institut);
            if($data->nature_stage == 'aplication') 
            $nature = "Application";
            else if($data->nature_stage == 'observation')
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

            $templateProcessor->setValue('theme_n', $data->theme);
            $templateProcessor->setValue('enc_name', $data->encadrant->nom ." ".$data->encadrant->prenom);
            $outputPath = "$directoryPath/fiche_de_stage_{$data->nom}_{$data->prenom}_{$anneeD}_{$moisD}.docx";
            $templateProcessor->saveAs($outputPath);
    
            $exist = fiches::where("path",'=',$outputPath)->exists();
            if($exist) {}
            else {
            $fiche = fiches::create([
                'path'=> $outputPath,
                'nom'=> $data->nom.' '.$data->prenom,
                'annee'=>$anneeD,
                'mois'=>$moisD,
                'nombre'=> $data->id,
                'type'=> 0
            ]);  }
            // Optionally, download the document
            return response()->download($outputPath)->deleteFileAfterSend(false);

        }
        else 
        {
            return back()->with('error','Un erreur est survenue');
        }
    }

    
}
