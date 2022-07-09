<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Therapist;
use App\Models\Appointment;

class HomeController extends Controller
{
    public function redirect()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype=='0')

            {
                $therapist = Therapist::all();
                return view('user.home',compact('therapist'));
            }

            else 
            {
                return view('admin.home');            }

        }

        else
        {
            return redirect()->back();
        }
    }

    public function index()
    {

        if(Auth::id())
        {
            return redirect('home');
        }

        else

        {
        $therapist = Therapist::all();
        return view('user.home',compact('therapist'));       
        }
    }

    public function appointment(Request $request)
    {
        $data = new appointment;

        $data->name=$request->name;
        $data->email=$request->email;
        $data->date=$request->date;
        $data->phone=$request->phone;
        $data->message=$request->message;
        $data->therapist=$request->therapist;
        $data->status='In progress';

        if(Auth::id())
        {
            $data->user_id=Auth::user()->id;
        }

        $data->save();

        return redirect()->back();
     

    }

    public function myappointment()
    {
        if(Auth::id())
        
        {
       
            $userid=Auth::user()->id;

            $appoint=appointment::where('user_id',$userid)->get();

            return view('user.myappointment', compact('appoint'));
        
        }
        else
        
        {
        
            return redirect()->back();
        
        }
    }

    public function cancel_appoint($id)
    
    {
        $data=appointment::find($id);

        $data->delete();

        return redirect()->back();

    }

    public function contact()
    {
        return view('user.contact');
    }

}
