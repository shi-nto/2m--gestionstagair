<?php

namespace App\Http\Controllers;
use App\Models\attestation;
use App\Models\stagiaires;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\fiches;

class attestationController extends Controller
{
    //
    public function attestation($id){
        $data = stagiaires::findOrFail($id);
        
        if($data){
            $dateN = Carbon::now();
            $date = \Carbon\Carbon::parse($dateN);
            $year = $date->year;

            $donnee = attestation::latest('created_at')->first();

            if($donnee){
                if($year != $donnee->year){
                    $id =1;
                    attestation::where('id', '!=', $donnee->id)
                            ->where('year','=',$donnee->year)
                            ->delete();
                }   
                else 
                $id = $donnee->id_a+1;
            } else { 
                $id = 1;
         
                  
                        }
            $a = attestation::create([
                'id_a'=> $id,
                'year'=>$year 
            ]);
            $templateProcessor = new TemplateProcessor(storage_path('app/public/fiche/ATTESTATION_DE_STAGE.docx'));
                        // Set the locale to French
            Carbon::setLocale('fr');

            // Get the current date
            
            $mois = strtoupper($date->translatedFormat('F'));
            $annee = $date->year;
            $jour = $date->day;
            

            $dateDebut = \Carbon\Carbon::parse($data->date_debut);
            $moisD = strtoupper($dateDebut->translatedFormat('F'));
            $anneeD = $dateDebut->year;
            $nbrMois = $dateDebut->month;
            $jourD = $dateDebut->day;
            if($data->prolongation->isNotEmpty()){
                $dateFin = \Carbon\Carbon::parse($data->prolongation->first()->date_fin);
            } else { 
                $dateFin = \Carbon\Carbon::parse($data->date_fin);
            }
            $moisF = strtoupper($dateFin->translatedFormat('F'));
            $anneeF = $dateFin->year;
            $jourF = $dateFin->day;
             // Create directory path
            $directoryPath = storage_path("app/public/fiche/Attestations/$anneeD/$moisD");

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
            if($mois == "AOûT")
            $mois = "AOUT";

            // Set the values in the template
            $templateProcessor->setValue('day', $jour); // Set the formatted date
            $templateProcessor->setValue('month', $mois);
            $templateProcessor->setValue('year', $annee);
            $templateProcessor->setValue('id', $a->id_a);
            $templateProcessor->setValue('anneeD', $anneeD);
            if($data->gender == 0 ){
                $templateProcessor->setValue('m', "Mme");
                $templateProcessor->setValue('e', "e");
            } else {
                $templateProcessor->setValue('m', "Mr");
                $templateProcessor->setValue('e', "");
            }
            $templateProcessor->setValue('departement', $data->encadrant->departement->nom);
            $templateProcessor->setValue('full_name', $data->nom ." ".$data->prenom);
            $templateProcessor->setValue('dayD', $jourD);
            $templateProcessor->setValue('yearD', $anneeD);
            $templateProcessor->setValue('monthD', $moisD);

            $templateProcessor->setValue('nbrMois', $nbrMois);

            $templateProcessor->setValue('dayF', $jourF);
            $templateProcessor->setValue('yearF', $anneeF);
            $templateProcessor->setValue('monthF', $moisF);
            $outputPath = "$directoryPath/attestation_de_stage_{$data->nom}_{$data->prenom}_{$anneeD}_{$moisD}.docx";
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
                'type'=> 1  
            ]);
        }
            // Optionally, download the document
            return response()->download($outputPath)->deleteFileAfterSend(false);
        }
        else 
        {
            return back()->with('error','Un erreur est survenue');
        }
    
    }

}
