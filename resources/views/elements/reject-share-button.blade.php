@php
    /**
    *
    * @var string $buttonText
    * @var string $urlId
    * @var string $userId
    *
    **/
@endphp

@if($buttonText)
    <button class="btn btn-primary btn-block unshare-button" data-user-id="{{$userId}}" data-url-id="{{$urlId}}" type="button">{{ $buttonText }}</button>
@endif