<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\CommentOrReplyDislike;
use App\Models\CommentOrReplyLike;
use App\Models\Reply;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CommentsComponent extends Component
{
    public $video;
    public $video_id, $user_id, $channel_id, $comment_content;
    public $reply_content;
    public $comments;
    public $clickedCommentId;
    public $comment_id;

    public $numberOfShownComments = 4;
    public $totalNumberOfComments;
    public $allCommetsOfCurrentVideo;
    public $clickedCommentIdForLike;
    public $clickedReplyIdForLike;
    public $clickedCommentIdForDislike;
    public $clickedReplyIdForDisLike;

    public $clickedCommentUserId;
    public $clickedCommentVideoId;

    public $clickedCommentToDeleteId;
    public $clickedCommentToDeleteUserId;

    public $clickedReplyToDeleteId;
    public $clickedReplyToDeleteUserId;

    protected function rules()
    {
        if ($this->clickedCommentId != null) {
            return [
                'video_id' => 'required',
                'comment_id' => 'required',
                'user_id' => 'required',
                'channel_id' => 'required',
                'reply_content' => 'required|string|min:6'
            ];
        }
        return [
            'video_id' => 'required',
            'user_id' => 'required',
            'channel_id' => 'required',
            'comment_content' => 'required|string|min:6',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function addComment() {
        if (auth()->check()) {
            $this->video_id = $this->video->id;
            $this->user_id = auth()->user()->id;
            if (auth()->user()->channel_id !== null) {
                $this->channel_id = auth()->user()->channel->id;
            } else {
                return redirect(route('show-new-channel-form'));
            }
            

            $this->validate();

            $insertedData = Comment::create([
                'video_id' => $this->video_id,
                'user_id' => $this->user_id,
                'channel_id' => $this->channel_id,
                'comment_content' => $this->comment_content,
            ]);
            
            if ($insertedData) {
                session()->flash('addCommentSuccessMessage', __('The comment has been added successfully!'));
                $this->resetInputs();

                $channelOfTheCurrentUserLoggedIn = auth()->user()->channel;
                $userNotification = new UserNotification();
                $userNotification->user_id = $this->video->author->id;
                $userNotification->channel_id = $channelOfTheCurrentUserLoggedIn->id;
                $userNotification->video_id = $this->video->id;
                $userNotification->video_comment_notify = true;
                $userNotification->comment_id = $insertedData->id;
                $userNotification->save();
            } else {
                session()->flash('addCommentErrorMessage', __('Something went wrong!'));
            }
        }
    }

    public function resetInputs() {
        $this->comment_content = '';
        $this->reply_content = '';
    }

    public function replyToSpecificComment($clickedCommentIdFromBlade, $clickedCommentUserIdFromBlade, $clickedCommentVideoIdFromBlade)
    {
        $this->clickedCommentId = $clickedCommentIdFromBlade;
        $this->clickedCommentUserId = $clickedCommentUserIdFromBlade;
        $this->clickedCommentVideoId = $clickedCommentVideoIdFromBlade;
    }

    public function addReplyToComment() {
        if (auth()->check()) {
            $this->video_id = $this->video->id;
            $this->comment_id = $this->clickedCommentId;
            $this->user_id = auth()->user()->id;
            $this->channel_id = auth()->user()->channel->id;

            $this->validate();
            
            $insertedData = Reply::create([
                'video_id' => $this->video_id,
                'comment_id' => $this->comment_id,
                'user_id' => $this->user_id,
                'channel_id' => $this->channel_id,
                'reply_content' => $this->reply_content,
            ]);
            
            if ($insertedData) {
                session()->flash('addReplyToCommentSuccessMessage', __('The reply has been successfully added!'));
                $this->resetInputs();
                $this->clickedCommentId = null;

                $channelOfTheCurrentUserLoggedIn = auth()->user()->channel;
                $userNotification = new UserNotification();
                $userNotification->user_id = $this->clickedCommentUserId;
                $userNotification->channel_id = $channelOfTheCurrentUserLoggedIn->id;
                $userNotification->video_id = $this->clickedCommentVideoId;
                $userNotification->comment_reply_notify = true;
                $userNotification->comment_id = $this->comment_id;
                $userNotification->reply_id = $insertedData->id;
                $userNotification->save();
            } else {
                session()->flash('addReplyToCommentErrorMessage', __('Something went wrong!'));
            }
        }
    }

    public function loadMoreComments() {
        // Verificăm daca mai există comentarii de încărcat
        if ($this->numberOfShownComments < $this->totalNumberOfComments) {
            // Creștem numărul de comentarii afișate cu 4
            $this->numberOfShownComments += 4;
            // Actualizăm variabila $comments pentru a afișa comentariile noi
            $newComments = Comment::where('video_id', $this->video->id)->orderBy('created_at', 'desc')
                ->skip($this->numberOfShownComments)
                ->take(4)
                ->get();
            $this->comments = $this->comments->concat($newComments);
        }
    }

    public function likeToSpecificComment($clickedCommentIdFromBlade) {
        $this->clickedCommentIdForLike = $clickedCommentIdFromBlade;
        //Inserare unica pentru o combinație de valori:
        if (auth()->check()) {
            $theExistingLikeInTheDatabase = CommentOrReplyLike::where('comment_id', $this->clickedCommentIdForLike)->where('user_id', auth()->user()->id)->first();
            $theExistingDislikeInTheDatabase = CommentOrReplyDislike::where('comment_id', $this->clickedCommentIdForLike)->where('user_id', auth()->user()->id)->first();
            if ($theExistingLikeInTheDatabase) {
                $theExistingLikeInTheDatabase->delete();
            } else if ($theExistingDislikeInTheDatabase){
                $theExistingDislikeInTheDatabase->delete();
                CommentOrReplyLike::firstOrCreate(['video_id' => $this->video->id, 'comment_id' => $this->clickedCommentIdForLike, 'user_id' => auth()->user()->id]);
            } else {
                CommentOrReplyLike::firstOrCreate(['video_id' => $this->video->id, 'comment_id' => $this->clickedCommentIdForLike, 'user_id' => auth()->user()->id]);
            }
        } else {
            return redirect(route('login'));
        }
        /*
        Această metodă firstOrCreat() va căuta în baza de date un înregistrare care să corespundă cu valorile din
         array-ul asociativ ['comment_id' => $videoId, 'user_id' => $userId].
         Dacă găsește o înregistrare, va returna acea înregistrare, 
         altfel va crea o nouă înregistrare cu aceste valori și va salva în baza de date.
        Astfel, se va asigura că există o singură înregistrare pentru fiecare combinație unică de video_id și user_id.
        */
    }

    public function likeToSpecificReply($clickedReplyIdFromBlade) {
        $this->clickedReplyIdForLike = $clickedReplyIdFromBlade;
        if (auth()->check()) {
            $theExistingLikeInTheDatabase = CommentOrReplyLike::where('reply_id', $this->clickedReplyIdForLike)->where('user_id', auth()->user()->id)->first();
            $theExistingDislikeInTheDatabase = CommentOrReplyDislike::where('reply_id', $this->clickedReplyIdForLike)->where('user_id', auth()->user()->id)->first();
            if ($theExistingLikeInTheDatabase) {
                $theExistingLikeInTheDatabase->delete();
            } else if ($theExistingDislikeInTheDatabase){
                $theExistingDislikeInTheDatabase->delete();
                CommentOrReplyLike::firstOrCreate(['video_id' => $this->video->id, 'reply_id' => $this->clickedReplyIdForLike, 'user_id' => auth()->user()->id]);
            } else {
                CommentOrReplyLike::firstOrCreate(['video_id' => $this->video->id, 'reply_id' => $this->clickedReplyIdForLike, 'user_id' => auth()->user()->id]);
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function dislikeToSpecificComment($clickedCommentIdFromBlade) {
        $this->clickedCommentIdForDislike = $clickedCommentIdFromBlade;
        if (auth()->check()) {
            $theExistingDislikeInTheDatabase = CommentOrReplyDislike::where('comment_id', $this->clickedCommentIdForDislike)->where('user_id', auth()->user()->id)->first();
            $theExistingLikeInTheDatabase = CommentOrReplyLike::where('comment_id', $this->clickedCommentIdForDislike)->where('user_id', auth()->user()->id)->first();
            if ($theExistingDislikeInTheDatabase) {
                $theExistingDislikeInTheDatabase->delete();
            } else if ($theExistingLikeInTheDatabase){
                $theExistingLikeInTheDatabase->delete();
                CommentOrReplyDislike::firstOrCreate(['video_id' => $this->video->id, 'comment_id' => $this->clickedCommentIdForDislike, 'user_id' => auth()->user()->id]);
            } else {
                CommentOrReplyDislike::firstOrCreate(['video_id' => $this->video->id, 'comment_id' => $this->clickedCommentIdForDislike, 'user_id' => auth()->user()->id]);
            }
        } else {
            return redirect(route('login'));
        } 
    }

    public function dislikeToSpecificReply($clickedCommentIdFromBlade) {
        $this->clickedReplyIdForDisLike = $clickedCommentIdFromBlade;
        if (auth()->check()) {
            $theExistingDislikeInTheDatabase = CommentOrReplyDislike::where('reply_id', $this->clickedReplyIdForDisLike)->where('user_id', auth()->user()->id)->first();
            $theExistingLikeInTheDatabase = CommentOrReplyLike::where('reply_id', $this->clickedReplyIdForDisLike)->where('user_id', auth()->user()->id)->first();
            if ($theExistingDislikeInTheDatabase) {
                $theExistingDislikeInTheDatabase->delete();
            } else if ($theExistingLikeInTheDatabase){
                $theExistingLikeInTheDatabase->delete();
                CommentOrReplyDislike::firstOrCreate(['video_id' => $this->video->id, 'reply_id' => $this->clickedReplyIdForDisLike, 'user_id' => auth()->user()->id]);
            } else {
                CommentOrReplyDislike::firstOrCreate(['video_id' => $this->video->id, 'reply_id' => $this->clickedReplyIdForDisLike, 'user_id' => auth()->user()->id]);
            }
        } else {
            return redirect(route('login'));
        } 
    }

    public function deleteToSpecificComment($clickedCommentToDeleteIdFromBlade, $clickedCommentToDeleteUserIdFromBlade)
    {
        $this->clickedCommentToDeleteId = $clickedCommentToDeleteIdFromBlade;
        $this->clickedCommentToDeleteUserId = $clickedCommentToDeleteUserIdFromBlade;
    }

    public function destroyComment() {
        if (auth()->user()->id == $this->clickedCommentToDeleteUserId) {
            //Gasim comentariul pentru care dorim sa gasim raspunsurile:
            $comment = Comment::find($this->clickedCommentToDeleteId);
            /*Gasim toate raspunsurile la comentariul respectiv si sterge toate like-urile,
            Folosim with('likes') pentru a incarca toate like-urile asociate fiecarui raspuns inainte de a le sterge:*/
            $comment->replies()->with('likes')->get()->each(function($reply) {
                $reply->likes()->delete();
            });
            /*Acest cod va obține comentariul cu ID-ul specificat, va încărca toate răspunsurile acestuia 
            cu dislike-urile asociate, apoi va itera prin fiecare răspuns și va șterge toate dislike-urile 
            asociate cu acel răspuns:*/
            $comment = Comment::find($this->clickedCommentToDeleteId);
            $comment->replies()->with('dislikes')->get()->each(function($reply) {
                $reply->dislikes()->delete();
            });
            // Comment::find($this->clickedCommentToDeleteId)->replies()->delete(); //Metoda alternativa pentru linia urmatoare:
            DB::delete('DELETE FROM replies WHERE comment_id = ?', [$this->clickedCommentToDeleteId]);
            DB::delete('DELETE FROM users_notifications WHERE comment_id = ?', [$this->clickedCommentToDeleteId]);
            DB::delete('DELETE FROM comments_and_replies_likes WHERE comment_id = ?', [$this->clickedCommentToDeleteId]);
            DB::delete('DELETE FROM comments_and_replies_dislikes WHERE comment_id = ?', [$this->clickedCommentToDeleteId]);
            $deletedComment = Comment::find($this->clickedCommentToDeleteId)->delete();
            if ($deletedComment) {
                session()->flash('deleteCommentSuccessMessage', __('The comment has been successfully deleted!'));
            } else {
                session()->flash('deleteCommentErrorMessage', __('Something went wrong!'));
            }
        }
    }

    public function deleteToSpecificReply($clickedReplyToDeleteIdFromBlade, $clickedReplyToDeleteUserIdFromBlade)
    {
        $this->clickedReplyToDeleteId = $clickedReplyToDeleteIdFromBlade;
        $this->clickedReplyToDeleteUserId = $clickedReplyToDeleteUserIdFromBlade;
    }

    public function destroyReply() {
        if (auth()->user()->id == $this->clickedReplyToDeleteUserId) {
            DB::delete('DELETE FROM users_notifications WHERE reply_id = ?', [$this->clickedReplyToDeleteId]);
            DB::delete('DELETE FROM comments_and_replies_likes WHERE reply_id = ?', [$this->clickedReplyToDeleteId]);
            DB::delete('DELETE FROM comments_and_replies_dislikes WHERE reply_id = ?', [$this->clickedReplyToDeleteId]);
            $deletedReply = Reply::find($this->clickedReplyToDeleteId)->delete();
            if ($deletedReply) {
                session()->flash('deleteReplySuccessMessage', __('The reply has been successfully deleted!'));
            } else {
                session()->flash('deleteReplyErrorMessage', __('Something went wrong!'));
            }
        }
    }

    public function render()
    {
        // $this->comments = Comment::where('video_id', $this->video->id)->get();
        $this->allCommetsOfCurrentVideo = Comment::where('video_id', $this->video->id)->orderBy('created_at', 'desc')->get();
        // Afișăm numărul de comentarii specificat:
        $this->comments = Comment::where('video_id', $this->video->id)->orderBy('created_at', 'desc')
            ->take($this->numberOfShownComments)
            ->get();
        // Afișăm numărul total de comentarii:
        $this->totalNumberOfComments = Comment::count();
        return view('livewire.comments-component', [$this->comments, $this->clickedCommentId, $this->allCommetsOfCurrentVideo]);
    }
}
