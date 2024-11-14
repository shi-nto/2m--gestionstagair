<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\users;
use App\Models\stagiaires;



class UserController extends Controller
{
    //

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('search');
        } else {
            $search = $request->get('search');
        }
        if($search=='admin') 
        $search = 1; 
        else if($search=='utilisateur')
        $search = 0;
        $data = users::where('first_name', 'like', '%' . $search . '%')
                          ->orWhere('second_name', 'like', '%' . $search . '%') 
                          ->orWhere('userName','like','%'.$search.'%')
                          ->orWhere('role','like','%'.$search.'%')
                          ->paginate(10);
            if($search==1) 
                          $search ='admin'; 
            else if($search==0)
                          $search = 'utilisateur';
        return view('admin.users', compact('data', 'search'))->render();
    }

    public function lister(){
        $data = users::orderBy('updated_at', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('admin.users',compact('data'))->render();
    }
    public function delete($id){
        $user = users::findOrFail($id);
    $user->delete();
    return redirect('/admin/users')->with('success','utilisateur supprimé');
    }

    public function edit($id){
        $data = users::findOrFail($id);
        return view('admin.userEdit',compact('data'));
    }

    public function index(Request $request)
    {
        $posts = stagiaires::with('encadrant.departement')
                            ->with('personnel.encadrant')
                            ->with('prolongation')
                            ->orderBy('updated_at', 'desc')
                            ->orderBy('id', 'desc')
                            ->paginate(10);

        if ($request->ajax()) {
            return view('user._stagiaire', compact('posts'))->render();
        }

        return view('user.home', compact('posts'));
    }

    public function loginPage()
    {
        //redirect u to the login form
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // Retrieve credentials from the request
        $credentials = $request->only('userName', 'password');
    
        // Attempt to authenticate the user
        if (Auth::attempt(['userName' => $credentials['userName'], 'password' => $credentials['password']])) {
            // Authentication was successful, retrieve the authenticated user
            $user = Auth::user();
            return redirect()->intended('/home'); // Redirect to home page
        }
        
    
        // Authentication failed, redirect back with error message
        return back()->withErrors([
            'userName' => 'The provided credentials do not match our records.',
        ]);
    }
    
   
        public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    public function update(Request $request, $id)
    {
       
    
        // Check if another user has the new userName
        $existingUser = users::where('userName', $request->userName)->where('id', '!=', $id)->exists();
        if ($existingUser) {
            return redirect("/admin/useredit/{$id}")->withErrors(['userName' => 'The UserName has already been taken by another user.'])->withInput();
        }
    
        // Find the user by ID or fail with a 404 error
        $user = users::findOrFail($id);
    
        // Update the user's details
        $user->userName = $request->userName;
        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name;
        $user->role = $request->role;
    
        // Update the password only if it's provided
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password); // Hash the password
        }
    
        // Save the changes to the database
        $user->save();
    
        // Redirect back to the edit page with a success message
        return redirect("/admin/users")->with("success", "Utilisateur modifié");
    }
    

    public function addUser (Request $request){
              // Retrieve input data
        $input = $request->only('first_name', 'second_name', 'userName', 'password','role');

       

        // 
        $existingEmail = users::where('userName', $input['userName'])->exists();
        if ($existingEmail) {
            return redirect('/admin/addUserForm')->withErrors(['userName' => 'The UserName has already been taken.'])->withInput();
        }

        // 
        $user = users::create([
            'first_name' => $input['first_name'],
            'second_name' => $input['second_name'],
            'role' => $input['role'],
            'userName' => $input['userName'],
            'password' => Hash::make($input['password']),
        ]);
        // 
        return redirect('/admin/users')->with("success","Utilisateur ajouté");
    }

    public function addUserForm(){
        return view('admin.addUser');
    }
    
}
