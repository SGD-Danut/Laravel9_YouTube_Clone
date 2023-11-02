<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddVideoRequest;
use App\Models\Category;
use App\Models\History;
use App\Models\UserNotification;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function showNewVideoForm() {
        if (auth()->user()->channel_id != null) {
            $categories = Category::all();
            return view('front.new-video-form')->with('categories', $categories);
        }
        return redirect(route('show-new-channel-form'));
    }
    
    public function addNewVideo(AddVideoRequest $request) {
        $video = new Video();

        // $ffmpegFullPath = "C:/xampp/htdocs/Laravel9_YouTube_Clone/public/ffmpeg/windows/ffmpeg";
        $ffmpegFullPath = realpath("ffmpeg/windows/ffmpeg.exe");
        $videoFileFromRequest = $request->file('videoFile');
        //Obtinere durată video:
        // $ffprobeFullPath = "C:/xampp/htdocs/Laravel9_YouTube_Clone/public/ffmpeg/windows/ffprobe";
        $ffprobeFullPath = realpath("ffmpeg/windows/ffprobe.exe");
        $unformattedDuration = shell_exec("$ffprobeFullPath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $videoFileFromRequest");
        $maxAllowedVideoDuration = 300;
        if ($unformattedDuration < $maxAllowedVideoDuration) {
            $hours = floor($unformattedDuration / 3600);
            $mins = floor(($unformattedDuration - ($hours*3600)) / 60);
            $secs = floor($unformattedDuration % 60);

            $hours = ($hours < 1) ? "" : $hours . ":";
            $mins = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";
            $secs = ($secs < 10) ? "0" . $secs : $secs;

            $formattedDuration = $hours . $mins . $secs;
            $video->duration = $formattedDuration;
            //Generare thumnail, dacă utilizatorul a bifat obțiunea:
            if ($request->generateThumbnail == 1) {
                $thumbnailName = str_replace(' ', '_', $request->title) . '_' . time() . '.jpg';
                $outputThumbnailPath = "images/thumbnails/";
                $fullOutputThumbnailPath = $outputThumbnailPath . $thumbnailName;
                $generateThumbnailCommand = "$ffmpegFullPath -i $videoFileFromRequest -ss 00:00:01.000 -vframes 1 $fullOutputThumbnailPath";
                system($generateThumbnailCommand);
                $video->thumbnail = $thumbnailName;
            }
            //Generare thumnail, în funcție de ce obțiune a bifat utilizatorul:
            if ($request->hasFile('videoFile')) {
                $videoFileExtention = $request->file('videoFile')->getClientOriginalExtension();
                $videoFileName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $videoFileExtention;
                if ($request->needsCompression == 'no') {
                    $request->file('videoFile')->move('videos', $videoFileName);
                } else if ($request->needsCompression != 'no') {
                    $outputVideoPath = "videos/";
                    $fullOutputVideoPath = $outputVideoPath . $videoFileName;
                    if ($request->needsCompression == 'yes-custom') {
                        $resolution = $request->resolution;
                        $compressVideoCommand = "$ffmpegFullPath -i $videoFileFromRequest -s $resolution $fullOutputVideoPath";
                    } else if ($request->needsCompression == 'yes-auto') {
                        $compressVideoCommand = "$ffmpegFullPath -i $videoFileFromRequest $fullOutputVideoPath";
                    }
                    system($compressVideoCommand);
                }
                $video->file_path = $videoFileName;
            }

            $video->title = $request->title;
            $video->slug = Str::slug($request->title) . '-' . Str::random(6) . time();
            $video->description = $request->description;
            //Alegere thumnail personal, dacă obțiunea de generare automată este dezactivată:
            if ($request->hasFile('thumbnail') && $request->generateThumbnail != 1) {
                $thumbnailExtention = $request->file('thumbnail')->getClientOriginalExtension();
                $thumbnailName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $thumbnailExtention;
                $request->file('thumbnail')->move('images/thumbnails', $thumbnailName);

                $video->thumbnail = $thumbnailName;
            }
            
            if ($request->published == 1) {
                $video->published = 1;
            } else {
                $video->published = 0;
            }

            $video->category_id = $request->video_category;
            /*
            Dacă utilizatorul are rolul de user în coloana user_id din tabela videos 
            se va completa cu id-ul utilizatorului curent autentificat:
            */
            if (auth()->user()->role == 'user') {
                $video->user_id = auth()->id();
            }
            $video->channel_id = auth()->user()->channel->id;
            $video->save();
            //Cod pentru notificarile utilizatorilor:
            $channelOfTheCurrentUserLoggedIn = Auth::user()->channel;
            foreach ($channelOfTheCurrentUserLoggedIn->subscribers()->get() as $subscriber) {
                $userNotification = new UserNotification();
                $userNotification->user_id = $subscriber->id;
                $userNotification->channel_id = $channelOfTheCurrentUserLoggedIn->id;
                $userNotification->video_id = $video->id;
                $userNotification->video_upload_notify = true;
                // $userNotification->message = "Canalul $channelOfTheCurrentUserLoggedIn->title a încărcat un videoclip nou: $video->title";
                $userNotification->save();
            }       

            return redirect(route('home'));
        } else {
            return redirect(route('show-new-video-form'))->with('error', __('You cannot upload a video with a duration longer than 5 minutes!'));
        }
    }

    public function showVideosToHomePage() {
        // $videos = Video::all();
        $videos = Video::where('published', 1)->inRandomOrder()->limit(10)->get();
        return view('front.home')->with('videos', $videos);
    }

    public function showCurrentVideo(Video $video) {
        $video->views++;
        $video->save();
        $videos = Video::where('slug', '!=', $video->slug)->where('published', 1)->inRandomOrder()->limit(5)->get();
        $videoURL = route('show-current-video', $video->slug);
        
        $history = new History();

        //Inserare unica pentru o combinație de valori:
        if (auth()->check()) {
            $history::firstOrCreate(['video_id' => $video->id, 'user_id' => auth()->user()->id]);
        }
        /*
        Această metodă firstOrCreat() va căuta în baza de date un înregistrare care să corespundă cu valorile din
         array-ul asociativ ['video_id' => $videoId, 'user_id' => $userId].
         Dacă găsește o înregistrare, va returna acea înregistrare, 
         altfel va crea o nouă înregistrare cu aceste valori și va salva în baza de date.
        Astfel, se va asigura că există o singură înregistrare pentru fiecare combinație unică de video_id și user_id.
        */
        return view('front.current-video')->with('video', $video)->with('videos', $videos)->with('videoURL', $videoURL);
    }

    public function showLikedVideos() {
        /* Metoda 1 de obtinere a videoclipurilor (RECOMANDATA):
        Dacă avem definită o relație one-to-many între tabelul "videos" și "likes", putem utiliza metoda "whereHas" 
        a query builder-ului din Laravel pentru a căuta toate videoclipurile care au cel puțin un like de la utilizatorul 
        autentificat. De exemplu codul următor:
        */

        $userId = auth()->user()->id;
        $likedVideos = Video::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get()->paginate(3);

        /* Acest cod va returna toate videoclipurile care au cel puțin un like din partea utilizatorului curent autentificat, 
        utilizând relația one-to-many între tabelele "videos" și "likes". */
        
        /* Metoda 2 de obtinere a videoclipurilor:
        Pentru a obține doar videoclipurile apreciate de utilizatorul curent autentificat, trebuie să efectuăm o interogare 
        asupra tabelului 'videos' pentru a obține toate înregistrările care au un rând corespunzător în tabelul 'likes' cu 
        'user_id' egal cu id-ul utilizatorului curent.
        Putem realiza acest lucru utilizând metoda 'join' a Query Builder-ului din Laravel pentru a uni cele două tabele pe 
        coloana 'video_id' și apoi să aplicăm o condiție asupra user_id pentru a selecta numai înregistrările care corespund 
        utilizatorului curent. În cele din urmă, vom utiliza metoda 'get' a Query Builder-ului pentru a returna toate 
        înregistrările.
        Un exemplu de cod ar putea arăta astfel:
        */

        // $likedVideos = DB::table('videos')
        //     ->join('likes', 'videos.id', '=', 'likes.video_id')
        //     ->where('likes.user_id', '=', Auth::user()->id)
        //     ->get();
            
        /* Acest cod va returna toate videoclipurile care au fost apreciate de către utilizatorul curent autentificat, 
        inclusiv toate coloanele din tabelul 'videos'. Aceste videoclipuri pot fi apoi afișate pe pagina respectivă utilizând Blade.
        Pentru a utiliza această metodă, trebuie să importăm clasa 'DB' și să asigurăm că utilizatorul curent este autentificat 
        folosind 'Auth::user()' pentru a accesa id-ul său. */

        return view('front.liked-videos.liked-videos')->with('likedVideos', $likedVideos);
    }

    public function showSearchedVideos(Request $request) {
        $validatetsearchVideoTerm = $this->validate(
            $request, 
            [
                'searchVideoTerm' => 'required'
            ]
        );
        if (request('searchVideoTerm')) {
            $searchVideoTerm = request('searchVideoTerm');
            $videos = Video::whereNotNull('published')
                ->where(function ($query) use ($searchVideoTerm) {
                    return $query
                    ->where('title', 'LIKE', "%{$searchVideoTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchVideoTerm}%")
                    ->orWhere('slug', 'LIKE', "%{$searchVideoTerm}%");
                })
                ->orderByDesc('created_at')
                ->paginate(3)
                ->withQueryString();
            return view('front.searched-videos.searched-videos')->with('videos', $videos)->with('searchVideoTerm', $searchVideoTerm);
        }    
    }
}
