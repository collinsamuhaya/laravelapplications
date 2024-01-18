<?php

namespace App\Http\Controllers;

use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use Notification;


class AdminController extends Controller
{
    Public function addview()
    {
        return view('admin.add_doctor');
    }
   
    Public function upload(Request $request)
    {
        $doctor= new doctor;
        
        $file = $request->file('doctorimage');
        $imagename=time().'.'.$file->getClientoriginalExtension();
       
        $request->doctorimage->move('doctorimagefolder',$imagename);
        
        $doctor->doctorimage = $imagename;
        $doctor->doctorsname = $request->doctorsname;
        $doctor->phone = $request->phone;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;

        $doctor->save();

        return redirect()->back()->with('message', 'Doctor added successfuly');    
    }

    public function showappointment()
    {
        $appoint=appointment::all();
        
        return view('admin.showappointments',compact('appoint'));
    }
    public function approveappointment($id)
{
$Data=appointment::find($id);
$Data->status='Approved';
$Data->save();
return redirect()->back();
}
public function cancelappointment($id)
{
$Data=appointment::find($id);
$Data->status='cancelled';
$Data->save();
return redirect()->back();
}
public function showdoctor()
{
$doctors=doctor::all();

return view('admin.showdoctor',compact('doctors'));
}
public function deletedoctor($id)
{
 $data=doctor::find($id);
 $data->delete();
 return redirect()->back();
}
public function updatedoctor($id)
{
 
    
 $doctors=doctor::find($id);
 return view('admin.updatedoctor',compact('doctors'));

}
Public function editdoctor(Request $request,$id)
{
    $doctor= doctor::find($id);
    
    $file = $request->file('doctorimage');
    if($file)
    {
    $imagename=time().'.'.$file->getClientoriginalExtension();
   
    $request->doctorimage->move('doctorimagefolder',$imagename);
    $doctor->doctorimage = $imagename;
    }
   
    $doctor->doctorsname = $request->doctorsname;
    $doctor->phone = $request->phone;
    $doctor->speciality = $request->speciality;
    $doctor->room = $request->room;

    $doctor->save();

    return redirect()->back()->with('message', 'Doctor updated successfuly');    
}
public function createemail($id)
{
  $Data=appointment::find($id);
    return view('admin.createemail',compact('Data'));

}
public function sendemail(Request $request, $id)
{
    $Data = appointment::find($id);
    $details=[
        'greeting'=> $request->greeting,
        'body'   => $request->body,
        'actiontext'=> $request->actiontext,
        'actionurl'=> $request->actionurl,
        'endpart'=> $request->endpart


    ];
    
   Notification::send($Data, new SendEmailNotification($details));
   return redirect()->back()->with('message', 'Email notification sent');    
}
    //
}
