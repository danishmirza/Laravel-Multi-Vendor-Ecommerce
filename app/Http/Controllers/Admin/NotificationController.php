<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
//        dd(Auth::guard('admin')->user()->notifications);
        return view('admin.dashboard.notifications.index', ['notifications' => Auth::guard('admin')->user()->notifications]);
    }

    public function readAll(){
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();
        return redirect()->route('admin.dashboard.notifications.index');
    }

    public function deleteAll(){
        Auth::guard('admin')->user()->unreadnotifications()->delete();
        return redirect()->back()->with('success', 'Notifications deleted successfully');
    }

    public function deleteOne($id){
        Auth::guard('admin')->user()->notifications()->where(['id' => $id])->delete();
        return redirect()->back()->with('success', 'Notification deleted successfully');
    }
}
