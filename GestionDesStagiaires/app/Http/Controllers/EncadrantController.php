<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\encadrants;
use App\Http\Controllers\DepartementController;
use App\Models\departements;
use App\Models\personnel;
use App\Models\stagiaires;

class EncadrantController extends Controller
{
    //
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('search');
        } else {
            $search = $request->get('search');
        }
    
        $data = encadrants::join('departements', 'encadrants.id_dep', '=', 'departements.id')
                          ->where('encadrants.nom', 'like', '%' . $search . '%')
                          ->orWhere('encadrants.prenom', 'like', '%' . $search . '%')
                          ->orWhere('departements.nom', 'like', '%' . $search . '%')
                          ->select('encadrants.*') // Select only columns from the encadrants table
                          ->paginate(10);
    
        return view('admin.encadrants', compact('data', 'search'))->render();
    }
    

    public function index(){
        $data= encadrants::with('departement')
        ->orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(10);
        
        return view('admin.encadrants',compact('data'))->render();
    }
    public function edit($id){
        $data = encadrants::with('departement')->findOrFail($id);
        $departements = departements::All();
        return view('admin.encEdit',compact("data","departements"));
    }

    public function update(Request $request){
        
        // Find the encadrants by ID
        $dep = encadrants::findOrFail($request->id);
    
        // Check if the new encadrants name already exists in the database
        $existingEnc = encadrants::where('nom', $request->nom)
                        ->where('prenom', $request->prenom)
                        ->where('id', '!=', $request->id)
                        ->first();

            if ($existingEnc) {
                return redirect("admin/encedit/$request->id")
                    ->with("error", "An encadrant with the same name and surname already exists. Please choose a different name.");
            }
    
        // Update encadrants name
        $dep->nom = $request->nom;
        $dep->prenom = $request->prenom;
        $dep->id_dep = $request->id_dep;
        $dep->save();
    
        return redirect("admin/encadrant")->with("success", "Updated successfully");
    }

    public function delete($id){
        
    $e=encadrants::findOrFail($id);
    $e->deleted = 1;
    $e->save();
    return redirect('/admin/encadrant')->with("success","deleted successfully");    

    }

    static public function All(){
        $encadrants = encadrants::orderBy('nom')
        
        ->get();

// Return the ordered collection
return $encadrants;
    }

    public function addEncForm(){
        $data=DepartementController::All();
        return view('admin.addEnc',compact('data'));
    }

    public function addEnc(Request $request){
        $input = $request->only('nom','prenom','id_dep');

        $existingRecord = encadrants::where('nom', $input['nom'])
                    ->where('prenom', $input['prenom'])
                    ->exists();

        if ($existingRecord) {
            return redirect('/admin/addEncForm')->with("error", "already exists. Please choose a different name.")->withInput();
        }

  
        // 
        $encadrants = encadrants::create([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'id_dep' => $input['id_dep'],
        ]);
        $perso = personnel::create([
            'id_enc' =>$encadrants->id,
         
        ]);
        // 
        return redirect('/admin/encadrant')->with("success","Encadrant ajouté");
    
    }

    public function restore($id){
        $dep = encadrants::findOrFail($id);
        $dep->deleted = 0; 
        $dep->save();
        return redirect('/admin/encadrant')->with('success','Encadrant restoré ');
    }
    public function deletedEnc(){
        $data = encadrants::where('deleted',1)->paginate(10);
        return view('admin.deletedEnc',compact('data'))->render();
    }
}
