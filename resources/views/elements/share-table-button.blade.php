@php
    /**
    *
    * @var string $buttonText
    * @var string $shareModalTarget
    *
    **/
@endphp

@if($buttonText)
    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="{{$shareModalTarget or '#share-modal'}}" type="button">{{ $buttonText }}</button>
@endif