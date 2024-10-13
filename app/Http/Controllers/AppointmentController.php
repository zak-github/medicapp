<?php

// app/Http/Controllers/AppointmentController.php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function calendar()
    {
        return view('templates.appointments.index');
    }
public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }


   
    public function store(Request $request)
    {
        $appointment = Appointment::insert([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        $appointment->start= $request->start;
        $appointment->end= $request->end;   

            $appointment->save();
       
        return response()->json($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
        return response()->json(['status' => 'Rendez-Vous Supprimé']);
    }
}


