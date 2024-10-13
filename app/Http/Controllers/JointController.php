<?php

namespace App\Http\Controllers;

use App\Models\Joint;
use Illuminate\Http\Request;

class JointController extends Controller
{
    public function index()
    {
        $joints = Joint::all();
        return view('templates.joints.index',['joints'=>$joints]);
    }

    public function create()
    {
        return view('templates.joints.create');
    }

    public function store(Request $request)//storrrrrrrrrrre
    {
        $request->validate([
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        $joint = new Joint();
        $jointV = Joint::where('id_consultation',$request->id_cons)->get();

          $joint->id_consultation=$request->id_cons;
          $joint->table_source=$request->table_src;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/joints'), $filename);
            $joint->file = 'uploads/joints/' . $filename;
        }


        $joint->save();
        return redirect('consultations/'.$request->id_cons.'/details')
                     ->with(['joint' => $jointV, 'success' => 'Jointe Créer Avec Succée.']);
       
    }

    public function show($id)
    {
        $joint = Joint::find($id);
        return view('templates.joints.show', compact('joint'));
    }

    public function edit($id)
    {
        $joint = Joint::find($id);
        return view('templates.joints.edit', compact('joint'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        $joint = Joint::find($id);
        $id_cons=Joint::where('id',$id)->value('id_consultation');
        $jointV = Joint::where('id_consultation',$id_cons)->get();
        if ($request->hasFile('file')) {
            if ($joint->file && file_exists(public_path($joint->file))) {
                unlink(public_path($joint->file));
            }

            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/joints'), $filename);
            $joint->file = 'uploads/joints/' . $filename;
        }

        $joint->save();

        //return redirect()->route('joints.index')->with('success', 'Joint updated successfully.');
        return redirect('consultations/'.$id_cons.'/details')
                     ->with(['joint' => $jointV, 'success' => 'Jointe Modifier Avec Succée.']);
    }

    public function destroy($id)
    {
        $joint = Joint::find($id);
        $id_cons=Joint::where('id',$id)->value('id_consultation');
        $jointV = Joint::where('id_consultation',$id_cons)->get();

        if ($joint->file && file_exists(public_path($joint->file))) {
            unlink(public_path($joint->file));
        }
        
        $joint->delete();
        
        return redirect('consultations/'.$id_cons.'/details')
        ->with(['joint' => $jointV, 'success' => 'Jointe A été Supprimée Avec Succée.']);
    }
}
