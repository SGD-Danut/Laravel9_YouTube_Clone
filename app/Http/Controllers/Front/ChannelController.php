<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewChannelRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Playlist;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteUri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ChannelController extends Controller
{
    public function showChannelPage(Channel $channel) {
        return view('front.channel.master.channel')->with('channel', $channel);
    }

    public function showChannelHome(Channel $channel) {
        $specialVideo = Video::where('id', '=', $channel->special_video)->get();
        // dd($specialVideo);
        return view('front.channel.channel-home')->with('channel', $channel)->with('specialVideo', $specialVideo)->with('home', 'channel-home');
    }

    public function showChannelVideos(Channel $channel) {
        // $userId = Auth::id();
        // $videos = Video::where('user_id', "=", $userId)->get();
        // return view('front.channel.channel-videos')->with('videos', $videos);
        $paginatedVideos = $channel->videos->where('published', 1)->paginate(6);
        return view('front.channel.channel-videos')->with('channel', $channel)->with('videos', 'channel-videos')->with('paginatedVideos', $paginatedVideos);
    }

    public function showChannelPlaylists(Channel $channel) {
        $playlistsOfTheChannel = $channel->user->playlists->where('published', 1)->paginate(6);
        return view('front.channel.channel-playlists')->with('channel', $channel)->with('playlists', 'channel-playlists')->with('playlistsOfTheChannel', $playlistsOfTheChannel);
    }

    public function showChannelDetails(Channel $channel) {
        // $channelDetails = Channel::findOrFail(auth()->user()->channel_id);
        // return view('front.channel.channel-details')->with('about', $channelDetails);
        return view('front.channel.channel-details')->with('channel', $channel)->with('about', 'channelDetails');
    }

    public function showNewChannelForm() {
        if (auth()->user()->channel_id == null) {
            return view('front.channel.new-channel-form');
        }
        return redirect(route('home'));
    }

    public function createChannel(NewChannelRequest $request) {
        $channel = new Channel();
        $channel->title = $request->title;
        $channel->slug = Str::slug($request->title) . '-' . Str::random(6) . time();
        $channel->description = $request->description;
        $channel->contact = $request->contact;
        if ($request->hasFile('avatar')) {
            $avatarExtension = $request->file('avatar')->getClientOriginalExtension();
            $avatarName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $avatarExtension;
            $request->file('avatar')->move('images/avatars', $avatarName);

            $channel->avatar = $avatarName;
        }
        // if ($request->hasFile('banner')) {
        //     $bannerExtension = $request->file('banner')->getClientOriginalExtension();
        //     $bannerName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $bannerExtension;
        //     $request->file('banner')->move('images/banners', $bannerName);

        //     $channel->banner = $bannerName;
        // }
        $channel->user_id = auth()->user()->id;
        $channel->save();
        
        
        User::where('id', auth()->user()->id)->update(array('channel_id' => $channel->id));
        return redirect(route('show-channel-home', auth()->user()->channel->slug));
    }

    public function showChannelCustomizationPage() {
        return view('front.channel.manage.customization.channel-customization')->with('channelCustomizationPage', 'channelCustomizationPage');
    }

    public function showChannelCustomizationPageForBranding() {
        return view('front.channel.manage.customization.channel-customization-branding')->with('branding', 'branding');
    }

    public function updateChannelBranding(Request $request) {
        $theCurrentUserChannelId = auth()->user()->channel->id;
        $channel = Channel::findOrFail($theCurrentUserChannelId);
        if ($request->hasFile('avatar')) {
            if ($channel->avatar != 'default-avatar.png') {
                File::delete('images/avatars/' . $channel->avatar);
            }
            $avatarExtension = $request->file('avatar')->getClientOriginalExtension();
            $avatarName = str_replace(' ', '_', $channel->title) . '_' . time() . '.' . $avatarExtension;
            $request->file('avatar')->move('images/avatars', $avatarName);
            $channel->avatar = $avatarName;
        }
        if ($request->hasFile('banner')) {
            if ($channel->banner != 'default-banner.jpg') {
                File::delete('images/banners/' . $channel->banner);
            }
            $bannerExtension = $request->file('banner')->getClientOriginalExtension();
            $bannerName = str_replace(' ', '_', $channel->title) . '_' . time() . '.' . $bannerExtension;
            $request->file('banner')->move('images/banners', $bannerName);
            $channel->banner = $bannerName;
        }
        $channel->save();
        return redirect(route('show-channel-home', auth()->user()->channel->slug));
    }

    public function showChannelCustomizationPageForDetails() {
        $theCurrentUserChannelId = auth()->user()->channel->id;
        $channel = Channel::findOrFail($theCurrentUserChannelId);
        $channelURL = route('show-channel-home', auth()->user()->channel->slug);
        return view('front.channel.manage.customization.channel-customization-details')->with('channel', $channel)->with('channelURL', $channelURL)->with('details', 'details');
    }

    public function updateChannelDetails(Request $request) {
        $theCurrentUserChannelId = auth()->user()->channel->id;
        $channel = Channel::findOrFail($theCurrentUserChannelId);
        $channel->title = $request->title;
        $channel->description = $request->description;
        $channel->contact = $request->contact;
        $channel->save();
        return redirect(route('show-channel-details', auth()->user()->channel->slug));
    }

    public function showChannelCustomizationPageForLayout() {
        if (auth()->user()->channel_id != null) {
            $theCurrentUserChannelId = auth()->user()->channel->id;
            $videos = Video::where('channel_id', $theCurrentUserChannelId)->where('published', 1)->get();
            return view('front.channel.manage.customization.channel-customization-layout')->with('videos', $videos)->with('layout', 'layout');
        }
        return redirect(route('show-new-channel-form'));
    }

    public function updateChannelLayout(Request $request) {
        $theCurrentUserChannelId = auth()->user()->channel->id;
        $channel = Channel::findOrFail($theCurrentUserChannelId);
        $channel->special_video = $request->special_video;
        $channel->save();
        return redirect(route('show-channel-home', auth()->user()->channel->slug));
    }

    //Metode pentru gestionarea videoclipurilor de pe canalul utilizatorului:
    
    public function showChannelContentPage() {
        return view('front.channel.manage.content.channel-content')->with('channelContentPage', 'channelContentPage');
    }

    public function showChannelContentPageForVideos() {
        if (auth()->user()->channel_id != null) {
            $theCurrentUserChannelId = auth()->user()->channel->id;
            $videos = Video::where('channel_id', $theCurrentUserChannelId)->sortable(['created_at' => 'desc'])->paginate(4)->withQueryString();
            return view('front.channel.manage.content.channel-content-videos')->with('videos', $videos)->with('channelVideos', 'channelVideos');
        }
        return redirect(route('show-new-channel-form'));
    }

    public function showChannelContentPageForPlaylists() {
        if (auth()->user()->channel_id != null) {
            $theCurrentUserLoggedInId = auth()->user()->id;
            $playlists = Playlist::where('user_id', $theCurrentUserLoggedInId)->sortable(['created_at' => 'desc'])->paginate(4)->withQueryString();
            return view('front.channel.manage.content.channel-content-playlists')->with('playlists', $playlists)->with('channelPlaylists', 'channelPlaylists');
        }
    }

    public function channelContentEditVideoForm($videoId) {
        $categories = Category::all();
        if (auth()->user()->channel->videos->find($videoId)) {
            $video = Video::findOrFail($videoId);
            return view('front.channel.manage.content.channel-content-edit-video')->with('video', $video)->with('categories', $categories);
        }
        return back();
    }

    public function channelContentUpdateVideo($videoId, UpdateVideoRequest $request) {
        $video = Video::findOrFail($videoId);
        $video->title = $request->title;
        $video->description = $request->description;

        //Generare thumnail, dacă utilizatorul a bifat obțiunea:
        // $ffmpegFullPath = "C:/xampp/htdocs/Laravel9_YouTube_Clone/public/ffmpeg/windows/ffmpeg";
        $ffmpegFullPath = realpath("ffmpeg/windows/ffmpeg.exe");
        $currentVideoPath = 'videos/' . $video->file_path;
        if ($request->generateThumbnail == 1) {
            if ($video->thumbnail != 'defaultThumbnailImage.png') {
                File::delete('images/thumbnails/' . $video->thumbnail);
            }
            $thumbnailName = str_replace(' ', '_', $request->title) . '_' . time() . '.jpg';
            $outputThumbnailPath = "images/thumbnails/";
            $fullOutputThumbnailPath = $outputThumbnailPath . $thumbnailName;
            $generateThumbnailCommand = "$ffmpegFullPath -i $currentVideoPath -ss 00:00:01.000 -vframes 1 $fullOutputThumbnailPath";
            system($generateThumbnailCommand);
            $video->thumbnail = $thumbnailName;
        }

        if($request->hasFile('thumbnail')) {
            if ($video->thumbnail != 'defaultThumbnailImage.png') {
                File::delete('images/thumbnails/' . $video->thumbnail);
            }
            $photoExtension = $request->file('thumbnail')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('thumbnail')->move('images/thumbnails', $photoName);
    
            $video->thumbnail = $photoName;
        }

        $video->category_id = $request->video_category;
        if ($request->published == 1) {
            $video->published = 1;
        } else {
            $video->published = 0;
        }
        $video->save();
        return redirect(route('channel-content-videos'));
    }

    public function channelContentEditPlaylistForm($playlistId) {
        if (auth()->user()->playlists->find($playlistId)) {
            $playlist = Playlist::findOrFail($playlistId);
            return view('front.channel.manage.content.channel-content-edit-playlist')->with('playlist', $playlist);
        }
        return back();
    }
    
    public function channelContentUpdatePlaylist($playlistId, UpdatePlaylistRequest $request) {
        $playlist = Playlist::findOrFail($playlistId);
        $playlist->title = $request->title;
        $playlist->description = $request->description;

        if($request->hasFile('thumbnail')) {
            if ($playlist->thumbnail != 'default-playlist-logo.png') {
                File::delete('images/playlists/' . $playlist->thumbnail);
            }
            $photoExtension = $request->file('thumbnail')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('thumbnail')->move('images/playlists', $photoName);
    
            $playlist->thumbnail = $photoName;
        }

        if ($request->published == 1) {
            $playlist->published = 1;
        } else {
            $playlist->published = 0;
        }
        $playlist->save();
        return redirect(route('channel-content-playlists'));
    }

    public function channelContentDeleteVideo($videoId) {
        $video = Video::findOrFail($videoId);
        File::delete('videos/' . $video->file_path);
        
        if ($video->thumbnail != 'defaultThumbnailImage.png') {
            File::delete('images/thumbnails/' . $video->thumbnail);
        }

        DB::delete('DELETE FROM likes WHERE video_id = ?', [$videoId]);
        DB::delete('DELETE FROM dislikes WHERE video_id = ?', [$videoId]);
        $video->playlists()->detach();
        DB::delete('DELETE FROM comments WHERE video_id = ?', [$videoId]);
        DB::delete('DELETE FROM histories WHERE video_id = ?', [$videoId]);
        DB::delete('DELETE FROM users_notifications WHERE video_id = ?', [$videoId]);
        DB::delete('DELETE FROM replies WHERE video_id = ?', [$videoId]);
        DB::delete('DELETE FROM comments_and_replies_likes WHERE video_id = ?', [$videoId]);
        DB::delete('DELETE FROM comments_and_replies_dislikes WHERE video_id = ?', [$videoId]);
        $video->delete();
        return redirect(route('channel-content-videos'));
    }

    public function channelContentDeletePlaylist($playlistId) {
        $playlist = Playlist::findOrFail($playlistId);
        if ($playlist->thumbnail != 'default-playlist-logo.png') {
            File::delete('images/playlists/' . $playlist->thumbnail);
        }
        $playlist->videos()->detach();
        $playlist->delete();
        return redirect(route('channel-content-playlists'));
    }
}
