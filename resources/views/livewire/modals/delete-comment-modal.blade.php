
<!-- Delete Comment Modal -->
<div wire:ignore.self class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        @if (auth()->check())
          @if (!(session()->has('deleteCommentSuccessMessage')))
            <h2 id="deleteCommentModalLabel">{{ __('Are you sure you want to delete this comment?') }} 🤔</h2>
          @endif
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form wire:submit.prevent='destroyComment'>
        <div class="modal-body">
          <form wire:submit.prevent='destroyComment'>
            @if (session()->has('deleteCommentSuccessMessage'))
                <h5 style="color: red">{{ session('deleteCommentSuccessMessage') }}</h5>
            @endif
            @if (session()->has('deleteCommentErrorMessage'))
                <h5 style="color: red">{{ session('deleteCommentErrorMessage') }}</h5>
            @endif
            @if (!(session()->has('deleteCommentSuccessMessage')))
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
