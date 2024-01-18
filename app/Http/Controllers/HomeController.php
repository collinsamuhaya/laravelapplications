<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;

class HomeController extends Controller
{
    Public function redirect()
{
If (Auth::id())
{
if (Auth::user()->usertype =='0'){ 
    $doctor=doctor::all();
    return view('user.home',compact('doctor'));
}
else {return view('admin.home');}
}
Else
{
Return redirect()-> back();
}
}
Public function index()
{
    if (Auth::id())
    {
        return redirect('home');
    }
    else
    {
    $doctor=doctor::all();
    return view('user.home',compact('doctor'));
    }
}
public function uploadappointment(Request $request )
{
    $Data = new appointment;
    $Data->fullname=$request->fullname;
    $Data->emailaddress= $request->emailaddress;
    $Data->dateforappointment=$request->dateforappointment;
    $Data->doctorsname= $request->doctorsname;
    $Data->roomnumber=$request->roomnumber;
    $Data->message= $request->message;
    $Data->status='In progress';
    $Data->doctorsname= $request->doctorsname;
    if(Auth::id()){  $Data->user_id=Auth::User()->id;}

    $Data->save();

    return redirect()->back()->with('message','Appointment successful, we will contact you');


}
public function myappointment()
{
    if(Auth::id())
    {
        $userid=Auth::user()->id;
        $appoint=appointment::where('user_id',$userid)->get();
        return view('user.myappointment',compact('appoint'));
    }
    else
    {
        return redirect()->back();
    }
    
}
public function cancelappointment($id)
{
$Data=appointment::find($id);
$Data->delete();
return redirect()->back();
}

    //
}
