<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Joint;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    //start



//
public function index(){

    $listpat= Consultation::where('active',1)->paginate(10);
    if($listpat->isEmpty()) {
       
        return view('templates.consultaions.index',['pat' => []]);
    }
    return view('templates.consultaions.index',['pat'=> $listpat]); 
}
/**** */
public function create(){
    return view('templates.consultaions.create'); 
}

public function createC($name){
    return view('templates.consultaions.create',['namec'=>$name]); 
}
/*** */
public function store(Request $request){
  $con= new Consultation();

    $con->patient_id =$request->input('idpatient');
    $con->examen =$request->input('examen');
    $con->type =$request->input('typeC');
    $con->allergies =$request->input('allergy');
    $con->antecedent_per =$request->input('antiP');
    $con->antecedent_fam =$request->input('antiF');
    $con->montant =$request->input('montant');
    $con->dateC =$request->input('dateC');
    $con->heureC =$request->input('heureC');
    $con->active =1;
    
   
    $con->save();
    return redirect('consultations')->with('add', 'Consultation Ajouté Avec Succés');
}
/*** */
public function edit($id){
   $pat=Consultation::find($id);
   return view('templates.consultaions.edit',['pat'=>$pat]);
}
/**** */


/**** */

public function update(Request $request,$id){
    $con=Consultation::find($id);
    
    
    $con->examen =$request->input('examen');
    $con->type =$request->input('typeC');
    $con->allergies =$request->input('allergy');
    $con->antecedent_per =$request->input('antiP');
    $con->antecedent_fam =$request->input('antiF');
    $con->montant =$request->input('montant');
    $con->dateC =$request->input('dateC');
    $con->heureC =$request->input('heureC');
    $con->active =1;
    
    $con->save();
    return redirect('consultations')->with('success', 'Consultation modifiée avec succés');
}


/*** */
public function details($id)
{
    $joints = Joint::all();

    $pat = Consultation::find($id); // all data
    $patt2 = Consultation::where('id', $id)->pluck('patient_id')->first(); // pat_id

    if ($patt2) {
        $patt3 = Consultation::where('active', 1)->where('patient_id', $patt2)->get(); // select consultation of pat_id
        return view('templates.consultaions.details', ['pat' => $pat, 'cons' => $patt3, 'joints' => $joints]);
    } else {
        return view('templates.consultaions.details', ['pat' => []]);
    }
}


 
/**** */
/*** */
public function destroyS(Request $request){
    $validated = $request->validate([
        
        'id' => 'required|integer' 
    ]);
    $pat=Consultation::find($validated['id']);
    $pat->active = 0;
    $pat->save();
    $request->session()->flash('del', 'Consultation supprimée avec succèes.');
    // Return a response
    return response()->json();
}

/*** */

public function getCounts()
{
    $patientCount = Patient::count();
    $consultationCount = Consultation::count();
    $rdvCount = Appointment::count();
    $totalPrice = Consultation::sum('montant');

    return response()->json([
        'patientCount' => $patientCount,
        'consultationCount' => $consultationCount,
        'rdvCount' => $rdvCount,
        'totalPrice' => $totalPrice,
    ]);
}

/***  */

    //end
}