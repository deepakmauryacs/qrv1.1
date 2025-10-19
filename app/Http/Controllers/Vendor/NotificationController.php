<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(4);
        return view('vendor.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::findOrFail($request->notification_id);
        $notification->status = 'read';
        $notification->save();

        return response()->json(['message' => 'Notification marked as read successfully!']);
    }
}
