@extends('admin/master/master-page')

@section('head-title')
    {{ __('Admin') }}
@endsection

@section('content')
    <h1>{{ __('Administration') }}</h1>
    <br>
    <h6>{{ __('Welcome to the admin menu!') }}</h6>
    <p>{{ __('This menu can only be accessed by an administrator!') }}</p>
@endsection