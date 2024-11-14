<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\departements;
use App\Models\encadrants;


class DepartementController extends Controller
{
    //
    
public function search(Request $request)
{
     if ($request->ajax()) {
        $search = $request->get('search');
     }else {
    $search = $request->get('search');
}
    $data = departements::where('nom', 'like', '%'.$search.'%')
                      ->paginate(10);
                        return view('admin.departement', compact('data','search'))->render();
                  
}
    public function index(){
        $data= departements::orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(10);
        
            return view('admin.departement',compact('data'))->render();
    }
    public function update(Request $request){
        // Validate input
        $request->validate([
            'nom' => 'required|string|max:255', // Adjust max length as per your database field
        ]);
    
        // Find the department by ID
        $dep = departements::findOrFail($request->id);
    
        // Check if the new department name already exists in the database
        $existingDep = departements::where('nom', $request->nom)->where('id', '!=', $request->id)->first();
    
        if ($existingDep) {
            return redirect("admin/depedit/$request->id")->with("error", "Department name already exists. Please choose a different name.");
        }
    
        // Update department name
        $dep->nom = $request->nom;
        $dep->save();
    
        return redirect("admin/departement")->with("success", "Updated successfully");
    }
    
    public function edit($id){
        $data = departements::findOrFail($id);
        return view('admin.depEdit',compact("data"));
    }
    public function delete($id){
          
          $d=departements::findOrFail($id);
            $d->deleted = 1;
            $d->save();
            return redirect("admin/departement")->with("success","deleted successfully");
       
    }

    public static function All(){
        $departements = departements::orderBy('nom')->get();

        // Return the ordered collection
        return $departements;
    }
    public function addDepForm(){
        return view('admin.addDep');
    }
    
    public function addDep(Request $request){
     
            // Retrieve input data
      $input = $request->only('nom');

     

      // 
      $existingName = departements::where('nom', $input['nom'])->exists();
      if ($existingName) {
          return redirect('/admin/addDepForm')->withErrors(['nom' => 'The department has already been taken.'])->withInput();
      }

      // 
      $departements = departements::create([
          'nom' => $input['nom'],
      ]);
      // 
      return redirect("admin/departement")->with("success","ajouté avec succès");;
  
    }

    public function restore($id){
        $dep = departements::findOrFail($id);
        $dep->deleted = 0; 
        $dep->save();
        return redirect("admin/departement")->with('success','Département restoré ');
    }

    public function deletedDep(){
        $data = departements::where('deleted',1)->paginate(10);
        return view('admin.deletedDep',compact('data'))->render();
    }
}
