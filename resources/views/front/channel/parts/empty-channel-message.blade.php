<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
        <img class="d-block mx-auto mb-4" src="/images/channel/empty-channel-illustration.svg" alt="" width="180">
        <h1 class="fw-light">{{ __('You have no video!') }}</h1>
        <p class="lead text-muted">{{ __('Upload a video to get started.') }} {{ __('Start sharing your story and connecting with viewers.') }}</p>
        <p>
            <a href="{{ route('show-new-video-form') }}" class="btn btn-primary my-2">{{__ ('Upload video') }}</a>
        </p>
        </div>
    </div>
</section>