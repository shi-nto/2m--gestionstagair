<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stagiaires;
use DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        // Total number of interns
        $totalInterns = \DB::table('stagiaires')->count();
        if($totalInterns != 0){
        // Nature stage data
        $natureStageData = \DB::table('stagiaires')
            ->select('nature_stage', \DB::raw('count(*) as total'))
            ->groupBy('nature_stage')
            ->get();
        
        // Gender distribution data
        $genderData = \DB::table('stagiaires')
            ->select('gender', \DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();



            $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
            $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
        
            // Generate an array of years
            $years = [];
            for ($year = $startYear; $year <= $endYear; $year++) {
                $years[] = $year;
            }
        
            $yearlyData = [];
            foreach ($years as $year) {
                $count = DB::table('stagiaires')
                    ->whereYear('date_debut', '<=', $year)
                    ->where(function ($query) use ($year) {
                        $query->whereYear('date_fin', '>=', $year)
                              ->orWhereNull('date_fin');
                    })
                    ->count();
        
                $yearlyData[] = ['year' => $year, 'total' => $count];
            }
        

            
        // Collect years covered by each internship
        $allYears = \DB::table('stagiaires')
            ->selectRaw('YEAR(date_debut) as year')
            ->union(
                \DB::table('stagiaires')
                    ->selectRaw('YEAR(date_fin) as year')
                    ->whereNotNull('date_fin')
            )
            ->distinct()
            ->pluck('year')
            ->toArray();
    
        // Calculate range of years based on the minimum and maximum years
        $minYear = min($allYears);
        $maxYear = max($allYears);
    
        // Create a list of all years in the range
        $rangeYears = range($minYear, $maxYear);
    
        // Available years for the monthly flow chart (considering both date_debut and date_fin)
        $availableYears = $rangeYears;
    
        // Department data
        $departmentData = \DB::table('stagiaires')
            ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
            ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
            ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
            ->groupBy('departements.nom')
            ->get();
        
            $encadrants = \DB::table('encadrants')
            ->select('id', 'nom', 'prenom') // Adjust fields as needed
            ->orderBy('nom')
            ->get();
            return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'));
        } 
        else {
            $totalInterns=0;
            $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
            // Department data
        $departmentData = \DB::table('stagiaires')
        ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
        ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
        ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
        ->groupBy('departements.nom')
        ->get();
    
    $encadrants = \DB::table('encadrants')
        ->select('id', 'nom' , 'prenom') // Adjust fields as needed
        ->get();
        return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
        ->with('error', 'Aucun stagiaire n\'a été trouvé');
    
        }
    }
    
     

      public function getMonthlyData($year)
{
    // Initialize an array with all months set to 0
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $monthlyData = array_fill_keys($months, 0);

    // Fetch interns who started or ended in the specified year
    $interns = DB::table('stagiaires')
        ->whereYear('date_debut', '<=', $year)
        ->whereYear('date_fin', '>=', $year)
        ->get(['date_debut', 'date_fin']);

    foreach ($interns as $intern) {
        $start = strtotime($intern->date_debut);
        $end = strtotime($intern->date_fin);

        // Ensure the start and end dates are within the same year
        $startYear = date('Y', $start);
        $endYear = date('Y', $end);

        if ($startYear < $year) {
            $start = strtotime("$year-01-01");
        }
        if ($endYear > $year) {
            $end = strtotime("$year-12-31");
        }

        // Iterate through each month the intern was active
        while ($start <= $end) {
            $monthName = date('M', $start);
            $monthlyData[$monthName]++;
            $start = strtotime('+1 month', $start);
        }
    }

    return response()->json($monthlyData);
}

public function getInternsByEncadrantAndYear($encadrantId, $year)
{
    // Initialize an array with all months set to 0
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $monthlyData = array_fill_keys($months, 0);

    // Fetch interns data for the selected encadrant and year
    $interns = \DB::table('stagiaires')
        ->where('id_enc', $encadrantId)
        ->whereYear('date_debut', '<=', $year)
        ->whereYear('date_fin', '>=', $year)
        ->get(['date_debut', 'date_fin']);

    foreach ($interns as $intern) {
        $start = strtotime($intern->date_debut);
        $end = strtotime($intern->date_fin);

        // Ensure the start and end dates are within the same year
        $startYear = date('Y', $start);
        $endYear = date('Y', $end);

        if ($startYear < $year) {
            $start = strtotime("$year-01-01");
        }
        if ($endYear > $year) {
            $end = strtotime("$year-12-31");
        }

        // Iterate through each month the intern was active
        while ($start <= $end) {
            $monthName = date('M', $start);
            $monthlyData[$monthName]++;
            $start = strtotime('+1 month', $start);
        }
    }

    return response()->json($monthlyData);
}
    
public function getInternsByDepartment($year)
{
    // Initialize an array with departments and set counts to 0
    $departments = \DB::table('departements')
        ->pluck('nom')
        ->toArray();

    $departmentData = array_fill_keys($departments, 0);

    // Fetch interns who started or ended in the specified year, grouped by department
    $interns = \DB::table('stagiaires')
        ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
        ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
        ->whereYear('date_debut', '<=', $year)
        ->where(function ($query) use ($year) {
            $query->whereYear('date_fin', '>=', $year)
                  ->orWhereNull('date_fin');
        })
        ->select('departements.nom as department')
        ->get()
        ->pluck('department');

    foreach ($interns as $department) {
        if (isset($departmentData[$department])) {
            $departmentData[$department]++;
        }
    }

    return response()->json($departmentData);
}
public function getInternsByGender($year)
{
    // Initialize the gender counts
    $genderCounts = [
        'Female' => 0,
        'Male' => 0
    ];

    // Fetch interns who started or ended in the specified year, grouped by gender
    $interns = \DB::table('stagiaires')
        ->whereYear('date_debut', '<=', $year)
        ->where(function ($query) use ($year) {
            $query->whereYear('date_fin', '>=', $year)
                  ->orWhereNull('date_fin');
        })
        ->select('gender')
        ->get();

    foreach ($interns as $intern) {
        if ($intern->gender == 0) {
            $genderCounts['Female']++;
        } elseif ($intern->gender == 1) {
            $genderCounts['Male']++;
        }
    }

    return response()->json($genderCounts);
}



public function getInternsByNatureStage($year)
{
    // Initialize the nature_stage counts
    $natureStageCounts = [
        'Observation' => 0,
        'Application' => 0,
        'Fin d\'Étude' => 0
    ];

    // Fetch interns who are active during the selected year
    $interns = \DB::table('stagiaires')
        ->where(function ($query) use ($year) {
            $query->where(function ($query) use ($year) {
                // Intern starts before the end of the year and ends after the start of the year
                $query->whereDate('date_debut', '<=', "$year-12-31")
                      ->where(function ($query) use ($year) {
                          $query->whereDate('date_fin', '>=', "$year-01-01")
                                ->orWhereNull('date_fin');
                      });
            });
        })
        ->select('nature_stage')
        ->get();

    foreach ($interns as $intern) {
        switch ($intern->nature_stage) {
            case 'observation':
                $natureStageCounts['Observation']++;
                break;
            case 'aplication':
                $natureStageCounts['Application']++;
                break;
            case 'fin_etudes':
                $natureStageCounts['Fin d\'Étude']++;
                break;
        }
    }

    return response()->json($natureStageCounts);
}


public function nature(){
    
        // Total number of interns
        $totalInterns = \DB::table('stagiaires')->count();
        if($totalInterns != 0){
        // Nature stage data
        $natureStageData = \DB::table('stagiaires')
            ->select('nature_stage', \DB::raw('count(*) as total'))
            ->groupBy('nature_stage')
            ->get();
        

      
            $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
            $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
        
            // Generate an array of years
            $years = [];
            for ($year = $startYear; $year <= $endYear; $year++) {
                $years[] = $year;
            }
        
            $yearlyData = [];
            foreach ($years as $year) {
                $count = DB::table('stagiaires')
                    ->whereYear('date_debut', '<=', $year)
                    ->where(function ($query) use ($year) {
                        $query->whereYear('date_fin', '>=', $year)
                              ->orWhereNull('date_fin');
                    })
                    ->count();
        
                $yearlyData[] = ['year' => $year, 'total' => $count];
            }
        

            
        // Collect years covered by each internship
        $allYears = \DB::table('stagiaires')
            ->selectRaw('YEAR(date_debut) as year')
            ->union(
                \DB::table('stagiaires')
                    ->selectRaw('YEAR(date_fin) as year')
                    ->whereNotNull('date_fin')
            )
            ->distinct()
            ->pluck('year')
            ->toArray();
    
        // Calculate range of years based on the minimum and maximum years
        $minYear = min($allYears);
        $maxYear = max($allYears);
    
        // Create a list of all years in the range
        $rangeYears = range($minYear, $maxYear);
    
        // Available years for the monthly flow chart (considering both date_debut and date_fin)
        $availableYears = $rangeYears;
            return view('user.stats.nature', compact('totalInterns', 'natureStageData',  'yearlyData', 'availableYears'));
      
        } else {
            $totalInterns=0;
            $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
            // Department data
    
    
        return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
        ->with('error', 'Aucun stagiaire n\'a été trouvé');
    
        } 


        

    }



        public function gender(){
               // Total number of interns
        $totalInterns = \DB::table('stagiaires')->count();
        if($totalInterns != 0){
        // Nature stage data
      
        
        // Gender distribution data
        $genderData = \DB::table('stagiaires')
            ->select('gender', \DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();



            $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
            $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
        
            // Generate an array of years
            $years = [];
            for ($year = $startYear; $year <= $endYear; $year++) {
                $years[] = $year;
            }
        
            $yearlyData = [];
            foreach ($years as $year) {
                $count = DB::table('stagiaires')
                    ->whereYear('date_debut', '<=', $year)
                    ->where(function ($query) use ($year) {
                        $query->whereYear('date_fin', '>=', $year)
                              ->orWhereNull('date_fin');
                    })
                    ->count();
        
                $yearlyData[] = ['year' => $year, 'total' => $count];
            }
        

            
        // Collect years covered by each internship
        $allYears = \DB::table('stagiaires')
            ->selectRaw('YEAR(date_debut) as year')
            ->union(
                \DB::table('stagiaires')
                    ->selectRaw('YEAR(date_fin) as year')
                    ->whereNotNull('date_fin')
            )
            ->distinct()
            ->pluck('year')
            ->toArray();
    
        // Calculate range of years based on the minimum and maximum years
        $minYear = min($allYears);
        $maxYear = max($allYears);
    
        // Create a list of all years in the range
        $rangeYears = range($minYear, $maxYear);
    
        // Available years for the monthly flow chart (considering both date_debut and date_fin)
        $availableYears = $rangeYears;
    
        
            return view('user.stats.gender', compact('totalInterns',  'genderData', 'yearlyData', 'availableYears'));
        } 
        else {
            $totalInterns=0;
            $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
            // Department data
    
    
        return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
        ->with('error', 'Aucun stagiaire n\'a été trouvé');
    
        }              
        }


        public function depart(){
                 // Total number of interns
        $totalInterns = \DB::table('stagiaires')->count();
        if($totalInterns != 0){
 

            $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
            $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
        
            // Generate an array of years
            $years = [];
            for ($year = $startYear; $year <= $endYear; $year++) {
                $years[] = $year;
            }
        
            $yearlyData = [];
            foreach ($years as $year) {
                $count = DB::table('stagiaires')
                    ->whereYear('date_debut', '<=', $year)
                    ->where(function ($query) use ($year) {
                        $query->whereYear('date_fin', '>=', $year)
                              ->orWhereNull('date_fin');
                    })
                    ->count();
        
                $yearlyData[] = ['year' => $year, 'total' => $count];
            }
        

            
        // Collect years covered by each internship
        $allYears = \DB::table('stagiaires')
            ->selectRaw('YEAR(date_debut) as year')
            ->union(
                \DB::table('stagiaires')
                    ->selectRaw('YEAR(date_fin) as year')
                    ->whereNotNull('date_fin')
            )
            ->distinct()
            ->pluck('year')
            ->toArray();
    
        // Calculate range of years based on the minimum and maximum years
        $minYear = min($allYears);
        $maxYear = max($allYears);
    
        // Create a list of all years in the range
        $rangeYears = range($minYear, $maxYear);
    
        // Available years for the monthly flow chart (considering both date_debut and date_fin)
        $availableYears = $rangeYears;
    
        // Department data
        $departmentData = \DB::table('stagiaires')
            ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
            ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
            ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
            ->groupBy('departements.nom')
            ->get();
        
            return view('user.stats.depart', compact('totalInterns', 'yearlyData', 'availableYears', 'departmentData'));
        } 
        else {
            $totalInterns=0;
            $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
            // Department data
        $departmentData = \DB::table('stagiaires')
        ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
        ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
        ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
        ->groupBy('departements.nom')
        ->get();
        return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
        ->with('error', 'Aucun stagiaire n\'a été trouvé');
    
        }
        }


    public function year(){
                   // Total number of interns
        $totalInterns = \DB::table('stagiaires')->count();
        if($totalInterns != 0){
        
            $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
            $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
        
            // Generate an array of years
            $years = [];
            for ($year = $startYear; $year <= $endYear; $year++) {
                $years[] = $year;
            }
        
            $yearlyData = [];
            foreach ($years as $year) {
                $count = DB::table('stagiaires')
                    ->whereYear('date_debut', '<=', $year)
                    ->where(function ($query) use ($year) {
                        $query->whereYear('date_fin', '>=', $year)
                              ->orWhereNull('date_fin');
                    })
                    ->count();
        
                $yearlyData[] = ['year' => $year, 'total' => $count];
            }
        

            
        // Collect years covered by each internship
        $allYears = \DB::table('stagiaires')
            ->selectRaw('YEAR(date_debut) as year')
            ->union(
                \DB::table('stagiaires')
                    ->selectRaw('YEAR(date_fin) as year')
                    ->whereNotNull('date_fin')
            )
            ->distinct()
            ->pluck('year')
            ->toArray();
    
        // Calculate range of years based on the minimum and maximum years
        $minYear = min($allYears);
        $maxYear = max($allYears);
    
        // Create a list of all years in the range
        $rangeYears = range($minYear, $maxYear);
    
        // Available years for the monthly flow chart (considering both date_debut and date_fin)
        $availableYears = $rangeYears;
    
        // Department data
       
            return view('user.stats.year', compact('totalInterns',  'yearlyData', 'availableYears'));
        } 
        else {
            $totalInterns=0;
            $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
            // Department data
        $departmentData = \DB::table('stagiaires')
        ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
        ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
        ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
        ->groupBy('departements.nom')
        ->get();
    
    $encadrants = \DB::table('encadrants')
        ->select('id', 'nom' , 'prenom') // Adjust fields as needed
        ->get();
        return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
        ->with('error', 'Aucun stagiaire n\'a été trouvé');
    
        }
    }

    public function moisA(){
          // Total number of interns
          $totalInterns = \DB::table('stagiaires')->count();
          if($totalInterns != 0){
          // Nature stage data
         
              $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
              $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
          
              // Generate an array of years
              $years = [];
              for ($year = $startYear; $year <= $endYear; $year++) {
                  $years[] = $year;
              }
        
              
          // Collect years covered by each internship
          $allYears = \DB::table('stagiaires')
              ->selectRaw('YEAR(date_debut) as year')
              ->union(
                  \DB::table('stagiaires')
                      ->selectRaw('YEAR(date_fin) as year')
                      ->whereNotNull('date_fin')
              )
              ->distinct()
              ->pluck('year')
              ->toArray();
      
          // Calculate range of years based on the minimum and maximum years
          $minYear = min($allYears);
          $maxYear = max($allYears);
      
          // Create a list of all years in the range
          $rangeYears = range($minYear, $maxYear);
      
          // Available years for the monthly flow chart (considering both date_debut and date_fin)
          $availableYears = $rangeYears;
      
         
              return view('user.stats.moisA', compact('totalInterns', 'availableYears'));
          } 
          else {
              $totalInterns=0;
              $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
              // Department data
          $departmentData = \DB::table('stagiaires')
          ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
          ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
          ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
          ->groupBy('departements.nom')
          ->get();
      
          $encadrants = \DB::table('encadrants')
          ->select('id', 'nom', 'prenom') // Adjust fields as needed
          ->orderBy('nom')
          ->get();

          return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
          ->with('error', 'Aucun stagiaire n\'a été trouvé');
      
          }
    }

    public function enc(){
         // Total number of interns
         $totalInterns = \DB::table('stagiaires')->count();
         if($totalInterns != 0){
        
             $startYear = DB::table('stagiaires')->min(DB::raw('YEAR(date_debut)'));
             $endYear = DB::table('stagiaires')->max(DB::raw('YEAR(date_fin)'));
         
             // Generate an array of years
             $years = [];
             for ($year = $startYear; $year <= $endYear; $year++) {
                 $years[] = $year;
             }     
         // Collect years covered by each internship
         $allYears = \DB::table('stagiaires')
             ->selectRaw('YEAR(date_debut) as year')
             ->union(
                 \DB::table('stagiaires')
                     ->selectRaw('YEAR(date_fin) as year')
                     ->whereNotNull('date_fin')
             )
             ->distinct()
             ->pluck('year')
             ->toArray();
     
         // Calculate range of years based on the minimum and maximum years
         $minYear = min($allYears);
         $maxYear = max($allYears);
     
         // Create a list of all years in the range
         $rangeYears = range($minYear, $maxYear);
     
         // Available years for the monthly flow chart (considering both date_debut and date_fin)
         $availableYears = $rangeYears;
     
         
         
         $encadrants = \DB::table('encadrants')
         ->select('id', 'nom', 'prenom') // Adjust fields as needed
         ->orderBy('nom')
         ->get();

             return view('user.stats.enc', compact('totalInterns',  'availableYears', 'encadrants'));
         } 
         else {
             $totalInterns=0;
             $availableYears=$yearlyData= $genderData=$natureStageData=[]; 
             // Department data
         $departmentData = \DB::table('stagiaires')
         ->join('encadrants', 'stagiaires.id_enc', '=', 'encadrants.id')
         ->join('departements', 'encadrants.id_dep', '=', 'departements.id')
         ->select('departements.nom as department', \DB::raw('count(stagiaires.id) as total'))
         ->groupBy('departements.nom')
         ->get();
     
     $encadrants = \DB::table('encadrants')
         ->select('id', 'nom' , 'prenom') // Adjust fields as needed
         ->get();
         return view('user.stats', compact('totalInterns', 'natureStageData', 'genderData', 'yearlyData', 'availableYears', 'departmentData', 'encadrants'))
         ->with('error', 'Aucun stagiaire n\'a été trouvé');
     
         }
    }
}
