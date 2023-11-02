<div>
  @include('livewire.modals.delete-comment-modal')
  @include('livewire.modals.delete-reply-modal')
  <!--        video comment            -->
  <div class="comment">
    <div class="comment-heading flex">
      <h4>{{ $comments->count() }} {{ $comments->count() > 1 || $comments->count() == 0 ? __('comments') : __('comment') }}</h4>
      {{-- <h4> <i class="fa fa-list-ul"></i> <label>SORT BY</label> </h4> --}}
    </div>
  </div>

  <!--        video comment  by self           -->
  <div class="details comment_self flex">
    <div class="img">
      @if (auth()->check())
        @if (auth()->user()->channel_id != null)
            <img src="\images\avatars\{{ auth()->user()->channel->avatar }}" alt="" class="avatar-image">
        @endif
      @else
        <img src="\images\avatars\default-avatar.png" alt="" class="avatar-image">
      @endif
    </div>
    <div class="heading">
      @if (auth()->check())
        <form id="addCommentForm" wire:submit.prevent="addComment">
          <input type="text" wire:model="comment_content" placeholder="{{ __('Add a comment') }}...">
          @error('comment_content') <span style="color: red">{{ $message }}</span> @enderror
          @if (session()->has('addCommentSuccessMessage'))
              <h5 style="color: red">{{ session('addCommentSuccessMessage') }}</h5>
          @endif
          @if (session()->has('addCommentErrorMessage'))
              <h5 style="color: red">{{ session('addCommentErrorMessage') }}</h5>
          @endif
          {{-- <textarea wire:model="comment_content" placeholder="Add a comment...."></textarea> --}}
        </form>
      @else
          <h6 style="font-size: 14px;font-family: inherit;"><a href="{{ route('login') }}" style="color: royalblue">{{ __('Sign in') }}</a> {{ __('to be able to post a comment') }}.</h6>
      @endif  
    </div>
  </div>
  <!--        video comment  by other           -->
  @foreach ($comments as $comment)
    <div class="details_Comment">
      <div class="details flex">
        <div class="img">
          <img src="\images\avatars\{{ $comment->channel->avatar }}" class="avatar-image" />
        </div>
        <div class="heading">
          <h4>{{ $comment->channel->title }} <span>{{ $comment->created_at->diffForHumans() }}</span> </h4>
          <p> {{ $comment->comment_content }}</p>
          <div class="comment-like flex">
            <div class="icon">
              <a wire:click.prevent="likeToSpecificComment({{ $comment->id }})" title="{{ __('Like') }}">
                <i class="fa fa-thumbs-up" style="cursor: pointer"></i>
              </a>
              <label>{{ $comment->likes->count() }}</label>
            </div>
            <div class="icon">
              <a wire:click.prevent="dislikeToSpecificComment({{ $comment->id }})" title="{{ __('Dislike') }}">
                <i class="fa fa-thumbs-down" style="cursor: pointer"></i>
              </a>
              <label>{{ $comment->dislikes->count() }}</label>
            </div>
            <div class="icon">
              <a wire:click.prevent="replyToSpecificComment({{ $comment->id }}, {{ $comment->user_id }}, {{ $comment->video_id }})">
                  <label style="cursor: pointer" class="reply-button-label">{{ __('Reply') }}</label>
              </a>
            </div>
            @auth
              @if (auth()->user()->id == $comment->user_id)
                <div class="icon">
                  <label style="cursor: pointer" type="button" data-bs-toggle="modal" data-bs-target="#deleteCommentModal" wire:click="deleteToSpecificComment({{ $comment->id }}, {{ $comment->user_id }})" class="btn btn-danger delete-button-label">{{ __('Delete') }}</label>
                </div>
              @endif
            @endauth
          </div>
        </div>
      </div>
    </div>
    @if ($clickedCommentId == $comment->id)
      <!--        video comment  by other           -->
      <div class="replay" id="reply-section">
        <div class="details comment_self flex">
          <div class="img">
            @if (auth()->check())
                <img src="\images\avatars\{{ auth()->user()->channel->avatar }}" alt="" class="avatar-image">
            @else
                <img src="\images\avatars\default-avatar.png" alt="" class="avatar-image">
            @endif
          </div>
          <div class="heading">
            @if (auth()->check())
              <form id="addReplyToCommentForm" wire:submit.prevent="addReplyToComment">
                <input type="text" wire:model="reply_content" placeholder="{{ __('Add a reply') }}...">
                @error('reply_content') <span style="color: red">{{ $message }}</span> @enderror
                @if (session()->has('addReplyToCommentSuccessMessage'))
                    <h5 style="color: red">{{ session('addReplyToCommentSuccessMessage') }}</h5>
                @endif
                @if (session()->has('addReplyToCommentErrorMessage'))
                    <h5 style="color: red">{{ session('addReplyToCommentErrorMessage') }}</h5>
                @endif
                {{-- <textarea wire:model="content" placeholder="Add a comment...."></textarea> --}}
              </form>
            @else
              <h6 style="font-size: 12px;font-family: inherit;"><a href="{{ route('login') }}" style="color: royalblue">{{ __('Sign in') }}</a> {{ __('to be able to post a reply') }}.</h6>
            @endif
          </div>
        </div>
      </div>
    @endif
    @foreach ($comment->replies as $reply)
      <div class="replay">   
        <div class="details_Comment">
          <div class="details flex">
            <div class="img">
                <img src="\images\avatars\{{ $reply->channel->avatar }}" class="avatar-image" />
            </div>
            <div class="heading">
              <h4>{{ $reply->channel->title }} <span>{{ $reply->created_at->diffForHumans() }}</span> </h4>
              <p> {{ $reply->reply_content }}</p>
              <div class="comment-like flex">
                <div class="icon">
                  <a wire:click.prevent="likeToSpecificReply({{ $reply->id }})" title="{{ __('Like') }}">
                    <i class="fa fa-thumbs-up" style="cursor: pointer"></i>
                  </a>
                  <label>{{ $reply->likes->count() }}</label>
                </div>
                <div class="icon">
                  <a wire:click.prevent="dislikeToSpecificReply({{ $reply->id }})" title="{{ __('Dislike') }}">
                    <i class="fa fa-thumbs-down" style="cursor: pointer"></i>
                  </a>
                  <label>{{ $reply->dislikes->count() }}</label>
                </div>
                @auth
                  @if (auth()->user()->id == $reply->user_id)
                  <div class="icon">
                    <label style="cursor: pointer" type="button" data-bs-toggle="modal" data-bs-target="#deleteReplyModal" wire:click="deleteToSpecificReply({{ $reply->id }}, {{ $reply->user_id }})" class="btn btn-danger delete-button-label">{{ __('Delete') }}</label>
                  </div>
                  @endif
                @endauth
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @endforeach
  @if ($comments->count() < $allCommetsOfCurrentVideo->count())
      <button class="loadMoreCommentsButton" wire:click.prevent="loadMoreComments">{{ __('See more') }}</button>
  @endif
</div>