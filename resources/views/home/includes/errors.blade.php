@php
    /**
     * Created by PhpStorm.
     * User: aRosen_LN
     * Date: 31.05.2018
     * Time: 1:21
     */
@endphp

@section('errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
                <h5>{{__('home.errorTitle')}}</h5>
                <ul type="square">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
@show