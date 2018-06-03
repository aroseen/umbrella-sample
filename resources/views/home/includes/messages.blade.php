@php
    /**
     * Created by PhpStorm.
     * User: aRosen_LN
     * Date: 31.05.2018
     * Time: 1:21
     */
@endphp

@section('messages')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(($errors && !$errors->isEmpty()))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><strong>{{__('home.errorTitle')}}</strong></h4>
                    <ul type="square">
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><strong>{{__('home.successTitle')}}</strong></h4>
                    <p>{!! session('success') !!}</p>
                </div>
            @endif
        </div>
    </div>
@show