<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function showNotificationsPage() {
        $currentUserNotifications = Auth::user()->notifications()->latest()->get();
        return view('front.user-notifications.user-notifications', compact('currentUserNotifications'));
    }

    public function deleteUserNotification(Request $request, $notificationId) {
        $userNotification = UserNotification::findOrFail($notificationId);
        $userNotification->delete();
        return redirect(route('user-notifications'));
    }
}
