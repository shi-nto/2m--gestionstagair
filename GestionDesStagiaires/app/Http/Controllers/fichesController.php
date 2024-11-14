<?php

namespace App\Http\Controllers;
use App\Models\fiches;
use Illuminate\Http\Request;

class fichesController extends Controller
{
    //
    public function attestations(){
        $data = fiches::where('type','=','1')
        ->orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view('user.fiche.attestations',compact('data'));
    }

    public function searchA(Request $request)
    {
        if(empty($request)){
            return redirect('/ficheAttestation');
        }  else {

        
        $search = $request->get('search');
        $category = $request->get('category');
        
        $query = fiches::where('type','=','1');
        
        switch ($category) {
            case 'numero':
                $query->where('fiches.nombre', 'like',  $search  );
                break;
            case 'nom':
                $query->where('fiches.nom', 'like','%' . $search . '%' );
                break;
            case 'prenom':
                $query->where('fiches.nom', 'like', '%' . $search . '%' );
                break;
           case 'annee' : 
                $query->where('fiches.annee','like',$search);
                break;
            case 'mois' : 
                $query->where('fiches.mois','like','%'. $search.'%');
                break;
           
        }
    
        $data = $query->paginate(20);
    
        if ($request->ajax()) {
            return view('user._stagiaire', compact('posts'))->render();
        } else {
            return view('user.fiche.attestations', compact('data', 'search'));
        }
    }
    }

    public function searchP(Request $request)
    {
        if(empty($request)){
            return redirect('/ficheProlongation');
        } else {
            $search = $request->get('search');
            $category = $request->get('category');
            
            $query = fiches::where('type','=','2');
            
            switch ($category) {
                case 'numero':
                    $query->where('fiches.nombre', 'like',  $search  );
                    break;
                case 'nom':
                    $query->where('fiches.nom', 'like','%' . $search . '%' );
                    break;
                case 'prenom':
                    $query->where('fiches.nom', 'like', '%' . $search . '%' );
                    break;
               case 'annee' : 
                    $query->where('fiches.annee','like',$search);
                    break;
                case 'mois' : 
                    $query->where('fiches.mois','like','%'. $search.'%');
                    break;
               
            }
        
    
        $data = $query->paginate(20);
    
        if ($request->ajax()) {
            return view('user._stagiaire', compact('posts'))->render();
        } else {
            return view('user.fiche.prolongations', compact('data', 'search'));
        }
    }
    }

    public function searchI(Request $request)
    {
        if(empty($request)){
            return redirect('/ficheInitiale');
        }
        $search = $request->get('search');
        $category = $request->get('category');
        
        $query = fiches::where('type','=','0');
        
        switch ($category) {
            case 'numero':
                $query->where('fiches.nombre', 'like',  $search  );
                break;
            case 'nom':
                $query->where('fiches.nom', 'like','%' . $search . '%' );
                break;
            case 'prenom':
                $query->where('fiches.nom', 'like', '%' . $search . '%' );
                break;
           case 'annee' : 
                $query->where('fiches.annee','like',$search);
                break;
            case 'mois' : 
                $query->where('fiches.mois','like','%'. $search.'%');
                break;
           
        }
    
    
        $data = $query->paginate(20);
    
        if ($request->ajax()) {
            return view('user._stagiaire', compact('posts'))->render();
        } else {
            return view('user.fiche.initiale', compact('data', 'search'));
        }
    }

    public function delete($id){
        $a = fiches::findOrFail($id);
                
            if (file_exists($a->path)) {
                if (unlink($a->path)) {
                    
                } else {
                 
                    return back()->with("error"," Unable to delete the file");

                }
            } else {
             
                return back()->with("error"," File does not exist");

            }
        $a->delete();
        return back()->with("success","fichier Supprimé");
    }
    

    public function initiale(){
        $data = fiches::where('type','=','0')
        ->orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view('user.fiche.initiale',compact('data'));
    }


    public function prolongations(){
        $data = fiches::where('type','=','2')
        ->orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view('user.fiche.prolongations',compact('data'));
    }
    
    

    
}
