@extends('admin.master.master-page')

@section('head-title')
    {{ __('Categories') }}
@endsection

@section('big-title')
    {{ __('Categories') }}
@endsection

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">{{ __('Title') }}:</th>
                <th scope="col">{{ __('Actions') }}:</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $category)
                <tr>
                    <td>
                        {{ $category->title }}
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                            <a href="{{ route('edit-category-form', $category->id) }}"><button type="button" class="btn btn-primary">{{ __('Edit') }}</button></a> 
                            <form id="delete-category-form-with-id-{{ $category->id }}" action="{{ route('delete-category', $category->id) }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            <button type="button" class="btn btn-danger" onclick="
                                if(confirm('{{ __('Are you sure you want to delete the category:') }} {{ $category->title }}?')) {
                                    document.getElementById('delete-category-form-with-id-' + {{ $category->id }}).submit();
                                }
                                ">{{ __('Delete') }}
                            </button>                        
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection
