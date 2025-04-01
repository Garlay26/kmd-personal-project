<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::whereNull('customer_id')->paginate(10);
        return view('notification/list',['notifications' => $notifications]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $fields = $request->validate([
            'message' => 'required',
            'title' => 'required',
       ]);
       //Send Notti to All Customer
       $customer_id = null;
       $title = $fields['title'];
       $message = $fields['message'];
       $type = 'general';
       $type_id = null;
       $result = sendNoti($customer_id,$title,$message,$type,$type_id);
       if($result == TRUE){
        return redirect()->route('notifications')->with('message','Notification Sent');
       }
       else{
        return redirect()->route('notifications')->with('error','Google Service Temporarily Down');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'noti_id' => 'required',
        ]);

        $noti = Notification::find($fields['noti_id']);
        if($noti){
            $noti->delete();
            return redirect()->route('notifications')->with('message','Successfully Deleted Notification');
        }
        else{
            return redirect()->route('notifications')->with('error','Wrong Notification ID');
        }
    }
}
