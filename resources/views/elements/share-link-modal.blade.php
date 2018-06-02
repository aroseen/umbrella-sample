@php
    /**
    *
    * @var string $modalId
    *
    **/
@endphp

<div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="shareLinkModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareLinkModalTitle">{{__('home.shareModalTitle')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>{{__('home.selectUsersText')}}</strong>
                <select class="form-control input-lg" id="share-users-list" required title="{{__('home.shareModalTitle')}}"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('home.closeText')}}</button>
                <button type="button" class="btn btn-primary">{{__('home.shareText')}}</button>
            </div>
        </div>
    </div>
</div>