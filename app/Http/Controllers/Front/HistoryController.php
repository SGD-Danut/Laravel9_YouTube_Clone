<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function showVideoHistory() {
        $idFromCurrentUserLoggedIn = auth()->user()->id;
        // if (request('all')) {
        //     $historyFromCurrentUser = History::where('user_id', $idFromCurrentUserLoggedIn)->orderBy('created_at','desc')->get();
        // } else {
        //     $historyFromCurrentUser = History::where('user_id', $idFromCurrentUserLoggedIn)->orderBy('created_at','desc')->take(4)->get();
        // }
        $historyFromCurrentUser = History::where('user_id', $idFromCurrentUserLoggedIn)->orderBy('created_at','desc')->get()->paginate(3);
        return view('front.history.current-history')->with('historyFromCurrentUser', $historyFromCurrentUser);
    }

    public function deleteVideoFromHistory($historyId) {
        $historyOfAVideo = History::findOrFail($historyId);
        $historyOfAVideo->delete();
        return redirect(route('history'));
    }
}
