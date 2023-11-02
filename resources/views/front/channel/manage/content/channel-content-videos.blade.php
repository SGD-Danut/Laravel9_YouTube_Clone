@extends('front.channel.manage.content.channel-content')

@section('head-title')
  {{ __('Channel content') . ": " . __('Videos') }}
@endsection

@section('videos')
  @if (auth()->user()->channel->videos->count() > 0) 
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">@sortablelink('title', 'Video')</th>
            <th scope="col">{{ __('Visibility') }}</th>
            <th scope="col">@sortablelink('created_at', __("Upload date"))</th>
            <th scope="col">@sortablelink('views', __("Views"))</th>
            <th scope="col">{{ __("Likes") }} / {{ __("Dislikes") }}</th>
            <th scope="col">{{ __("Actions") }}</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach ($videos as $video)
          <tr>
            <td style="display: flex;">
              <img src="/images/thumbnails/{{ $video->thumbnail }}" width="120" alt="Lipsa imagine de tip thumbnail">
              <h6 style="padding-left: inherit;">{{ $video->title }}</h6>
            </td>
            <td class="text-center">{{ $video->published == 1 ? __('Published') : __('Unpublished') }}</td>
            <td class="text-center">{{ $video->created_at->format('d.m.Y') }}</td>
            <td class="text-center">{{ $video->views }}</td>
            <td class="text-center"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i> {{ $video->likes->count() }} &nbsp; &nbsp; <i class="fas fa-thumbs-down fa-lg"></i> {{ $video->dislikes->count() }}</td>
            <td>
              <div class="btn-group" role="group" aria-label="Action buttons">
                  <a href="{{ route('channel-content-edit-video-form', $video->id) }}"><button type="button" class="btn btn-primary btn-sm">{{ __('Edit') }}</button></a>
                  <form id="delete-video-form-with-id-{{ $video->id }}" action="{{ route('channel-content-delete-video', $video->id) }}" method="POST">
                      @csrf
                      @method('delete')
                  </form>
                  <button type="button" class="btn btn-danger btn-sm" onclick="
                    if(confirm('{{ __('Are you sure you want to delete the video:') }} {{ $video->title }}?')) {
                        document.getElementById('delete-video-form-with-id-' + {{ $video->id }}).submit();
                    }
                    ">{{ __('Delete') }}
                  </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
    {{ $videos->links() }}   
  @else
    @include('front.channel.parts.empty-channel-message')
  @endif
@endsection