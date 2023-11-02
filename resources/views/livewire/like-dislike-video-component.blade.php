<div style="display: flex;">
  <div class="icon">
    <button type="button" wire:click="likeVideo()" class="fa fa-thumbs-up mini-button" title="{{ __('Like') }}"></button>
    <label>{{ $currentVideo->likes->count() }}</label>
  </div>
  <div class="icon">
    <button type="button" wire:click="dislikeVideo()" class="fa fa-thumbs-down mini-button" title="{{ __('Dislike') }}"></button>
    <label>{{ $currentVideo->dislikes->count() }}</label>
  </div>
</div>
