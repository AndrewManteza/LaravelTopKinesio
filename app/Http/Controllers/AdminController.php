<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Therapist;

use App\Models\Appointment;



class AdminController extends Controller
{
    public function addview()
    {
        return view('admin.add_therapist');
    }

    public function upload(Request $request)
    {
        $therapist =new therapist;

       
        
        $image=$request->file;

        $imagename=time().'.'.$image->getClientoriginalExtension();
        
        $request->file->move('therapistpic',$imagename);
        $therapist->image=$imagename;

        $therapist ->name=$request->name;
        $therapist ->phone=$request->phone; 
        $therapist ->address=$request->address;
        $therapist ->email=$request->email;
    
        $therapist->save();

        return redirect()->back()->with('message', 'Doctor Added Successfully');

    }

    public function showappointment()
    {

        $data=appointment::all();


        return view('admin.showappointment', compact('data'));
    }

    public function approved($id)
    {

        $data=appointment::find($id);

        $data->status='approved';

        $data->save();

        return redirect()->back();


    }


    public function cancelled($id)
    {

        $data=appointment::find($id);

        $data->status='Rejected';

        $data->save();

        return redirect()->back();


    }


    public function showtherapist()
    {

        $data = therapist::all();

        return view('admin.showtherapist',compact('data'));
    }

    public function deletetherapist($id)
    {
        $data=therapist::find($id);

        $data->delete();

        return redirect()->back();
    }


    public function updatetherapist($id)
        {

            $data = therapist::find($id);
            return view('admin.updatetherapist',compact('data'));
        }
    

    public function edittherapist(Request $request, $id)
        {
            $therapist = therapist::find($id);

            $therapist->name=$request->name;

            $therapist->phone=$request->phone;

            $therapist->email=$request->email;

            $therapist->address=$request->address;

            $image=$request->file;

            if($image)
            {

            $imagename=time().'.'.$image->getClientOriginalExtension(); 

            $request->file->move('therapistpic', $imagename);

            $therapist->image=$imagename;

            }
 
            $therapist->save();

            return redirect()->back()->with('message','Therapist Details Updated Successfully');


        }


        public function emailview($id)
        {

            $data=appointment::find($id);
            return view('admin.email_view',compact('data'));
        }

}
