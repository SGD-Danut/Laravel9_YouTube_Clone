<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function showContentToLibraryPage() {
        $idFromCurrentUserLoggedIn = auth()->user()->id;
        $historyFromCurrentUser = History::where('user_id', $idFromCurrentUserLoggedIn)->orderBy('created_at','desc')->get()->take(6);

        $playlistsFromCurrentUser = auth()->user()->playlists->take(6);

        $likedVideos = Video::whereHas('likes', function ($query) use ($idFromCurrentUserLoggedIn) {
            $query->where('user_id', $idFromCurrentUserLoggedIn);
        })->get()->take(6);

        return view('front.library.library', compact('historyFromCurrentUser'))->with('playlistsFromCurrentUser', $playlistsFromCurrentUser)->with('likedVideos', $likedVideos);
    }
}
