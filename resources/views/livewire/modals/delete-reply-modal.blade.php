<!-- Delete Reply Modal -->
<div wire:ignore.self class="modal fade" id="deleteReplyModal" tabindex="-1" aria-labelledby="deleteReplyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        @if (auth()->check())
          @if (!(session()->has('deleteReplySuccessMessage')))
            <h2 id="deleteReplyModalLabel">{{ __('Are you sure you want to delete this reply?') }} 🤔</h2>
          @endif
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form wire:submit.prevent='destroyReply'>
        <div class="modal-body">
          <form wire:submit.prevent='destroyReply'>
            @if (session()->has('deleteReplySuccessMessage'))
                <h5 style="color: red">{{ session('deleteReplySuccessMessage') }}</h5>
            @endif
            @if (session()->has('deleteReplyErrorMessage'))
                <h5 style="color: red">{{ session('deleteReplyErrorMessage') }}</h5>
            @endif
            @if (!(session()->has('deleteReplySuccessMessage')))
              <button type="submit" class="addPlaylistButton">{{ __('Yes, delete it!') }}</button>
            @endif
            <button type="button" class="btn btn-secondary addPlaylistButton" data-bs-dismiss="modal">{{ __('Close') }}</button>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </form>
    </div>
  </div>
</div>
