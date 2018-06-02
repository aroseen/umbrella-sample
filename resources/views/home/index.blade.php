@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" id="user-id" value="{{auth()->user()->getAuthIdentifier()}}" />
        @include('home.includes.create')
        <br>
        @include('home.includes.links')
        <br>
        @include('home.includes.settings')
    </div>
    @include('elements.share-link-modal', [
        'modalId' => 'share-modal'
    ])
@endsection
