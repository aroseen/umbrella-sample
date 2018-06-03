@php
    /**
    *
    * @var string $buttonText
    * @var string $shareModalTarget
    * @var int $urlId
    *
    **/
@endphp

@if($buttonText)
    <button class="btn btn-primary btn-block open-share-dialog-button" data-toggle="modal" data-url-id="{{$urlId}}" data-target="{{$shareModalTarget or '#share-modal'}}" type="button">{{ $buttonText }}</button>
@endif