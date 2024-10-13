<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Auth;

class PatientController extends Controller
{
  
  
    public function dash() {
        // Get the current date
        $currentDate = Carbon::today();
    
        // Query the patients where rdv or created_at is equal to the current date
        $listpat = Patient::whereDate('rdv', $currentDate)
                          ->orWhereDate('created_at', $currentDate)
                          ->where('status','En Attente')
                          ->where('active',1)
                          ->get();
    
        // Check if the list is empty
        if ($listpat->isEmpty()) {
            return view('dashboard', ['pat' => []]);
        }
    
        return view('dashboard', ['pat' => $listpat]);
    }
    

    public function index(){

        $listpat= Patient::where('active',1)->paginate(5);
        if($listpat->isEmpty()) {
           
            return view('templates.patients.index',['pat' => []]);
        }
        return view('templates.patients.index',['pat'=> $listpat]); 
    }
/**** */
    public function create(){
        return view('templates.patients.create'); 
    }
    /*** */
    public function store(Request $request){
        $pat= new Patient();

        $pat->name =$request->input('name');
        $pat->cin =$request->input('cin');
        $pat->tel =$request->input('tel');
        $pat->address =$request->input('address');
        $pat->session =$request->input('session');
        $pat->rdv =$request->input('rdv');
        $pat->active =1;
        $pat->status ="En Attente";
        $pat->motif =$request->input('motif');
        $pat->assurence=$request->input('assurence');
        $pat->user_id=Auth::user()->id;
        $pat->name_user=Auth::user()->name;
        $pat->id_patient_doss = Str::random(10); 
        $pat->save();
        return redirect('patients')->with('add', 'Patient Ajouté Avec Succés');
    }
/*** */
    public function edit($id){
       $pat=Patient::find($id);
       return view('templates.patients.edit',['pat'=>$pat]);
    }
/**** */

/*** */
public function details($id){
    $pat=Patient::find($id);
    return view('templates.patients.details',['pat'=>$pat]);
 }
/**** */

    public function update(Request $request,$id){
        $pat=Patient::find($id);
        $pat->name =$request->input('name');
        $pat->cin =$request->input('cin');
        $pat->tel =$request->input('tel');
        $pat->address =$request->input('address');
        $pat->session =$request->input('session');
        $pat->rdv =$request->input('rdv');
        $pat->assurence=$request->input('assurence');
        $pat->status =$request->input('status');
        $pat->motif =$request->input('motif');
        
        $pat->save();
        return redirect('patients')->with('success', 'Patient modifiée avec succés');
    }
/*** */
    public function destroyS(Request $request){
        $validated = $request->validate([
            
            'id' => 'required|integer' 
        ]);
        $pat=Patient::find($validated['id']);
        $pat->active = 0;
        $pat->save();

        $request->session()->flash('del', 'Patient supprimé avec succès.');
        // Return a response
        return response()->json();
    }


    /**start fnct storstatus */
    public function storeStatus(Request $request) {
        $validated = $request->validate([
            'status' => 'required|string',
            'id' => 'required|integer' // Assuming you also want to use the ID for something
        ]);
        $pat=Patient::find($validated['id']);
        $pat->status = $validated['status'];
        $pat->save();
    
        // Return a response
        return response()->json(['message' => 'Patient status updated successfully', 'patient' => $pat], 200);
    }
    /****end status */



    /** function ajax */

public function dashAjax(Request $request) {
    $currentDate = Carbon::today();

    $listpat = Patient::where('active', "1")
                  ->where(function($query) use ($currentDate) {
                      $query->whereDate('rdv', $currentDate)
                            ->orWhereDate('created_at', $currentDate)
                            ->orWhereDate('updated_at', $currentDate);
                  })
                  ->get();


    return response()->json($listpat);
}


public function dashListe(Request $request) {
    $currentDate = Carbon::today();

    $listpat2 = Patient::where('status','En Attente')
    ->where('active',"1")
    ->get();

    return response()->json($listpat2);
}

/*** getnames start */
public function getPatientNames(Request $request)
{
    // Fetch active patients whose names match the search term
    $patients = Patient::where('active', '1')
                       ->where('name', 'like', '%' . $request->query('term', '') . '%')
                       ->with('consultations') // Eager load consultations
                       ->get(['id', 'name', 'cin']); // Select only the necessary columns

    // Customize the response to include consultation ID
    $response = $patients->map(function($patient) {
        return [
            'id' => $patient->id,
            'name' => $patient->name,
            'cin' => $patient->cin,
            'consultation_id' => $patient->consultations->isNotEmpty() ? $patient->consultations->first()->id : null, // Assuming you want the first consultation's ID
        ];
    });

    return response()->json($response);
}

/*
public function getPatientNames(Request $request)
{
    $patients = Patient::where('active', '1')
                       ->where('name', 'like', '%' . $request->query('term', '') . '%')
                       ->get(['name', 'cin','id']); // Include both 'name' and 'cin'
                       return response()->json($patients);
   
}**/
/** end getnames */

/*** */
public function attenteP(Request $request){
    $validated = $request->validate([
        
        'id' => 'required|integer' 
    ]);
    $pat=Patient::find($validated['id']);
    $pat->status = "En Attente";
    $pat->save();

    $request->session()->flash('add', "Patient Ajouté En Salle D'attente avec succès.");
    // Return a response
    return response()->json();
}







}
