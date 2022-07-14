<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Therapist;

use App\Models\Patient;

use App\Models\Appointment;

use Notification;

use App\Notifications\SendEmailNotification;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function addview()
    {

        if(Auth::id())

        {
            
            if(Auth::user()->usertype==1)
            {
            return view('admin.add_therapist');
            }
            else
        
            {
            return redirect()->back();
            }
        }

        
        else
        {
            return redirect('login');
        }
        

        
    }

    public function addviewpatient()
    {

        if(Auth::id())

        {
            
            if(Auth::user()->usertype==1)
            {
            return view('admin.add_patient');
            }
            else
        
            {
            return redirect()->back();
            }
        }

        
        else
        {
            return redirect('login');
        }
        

        
    }
    public function uploadPatient(Request $request)
    {
        $patient =new patient;

        $image=$request->image;
        $imagename=time().'.'.$image->getClientoriginalExtension();
        $request->image->move('patientpic',$imagename);
        
        $file=$request->file;
        $filename=time().'.'.$file->getClientoriginalExtension();
        $request->file->move('patientfiles',$filename);
        
        $patient->image=$imagename;
        $patient->file=$filename;
        $patient ->name=$request->name;
        $patient ->phone=$request->phone; 
        $patient ->address=$request->address;
        $patient ->email=$request->email;
        $patient ->description=$request->description;
    
        $patient->save();

        return redirect()->back()->with('message', 'PatientAdded Added Successfully');

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
        if(Auth::id())

        {
            
            if(Auth::user()->usertype==1)
            {

            $data=appointment::all();
            return view('admin.showappointment', compact('data'));
            
            }
            else
            {
            return redirect()->back();
            }
        }
        
        else
        {
            return redirect('login');
        }
   
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
    
        public function viewpatient()
        {
    
            $data = patient::all();
    
            return view('admin.view_patients',compact('data'));
        }


        public function deletepatient($id)
        {
            $data=user::find($id);
    
            $data->delete();
    
            return redirect()->back();
        }
    
    
        public function updatepatient($id)
            {
    
                $data = user::find($id);
                return view('admin.updatepatient',compact('data'));
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
            return view('admin.email_view',compact('data')
        );
        }

        public function sendemail(Request $request,$id)
        {
            $data = appointment::find($id);
            $details = 
            [
                'greet' => $request->Greet,
                'body' => $request->Body,
                'actiontext' => $request->ActionText,
                'actionurl' => $request->ActionText,
                'end' => $request->End 
            ];

            Notification::send($data,new SendEmailNotification($details));
      
      
            return redirect()->back();
        }

}
