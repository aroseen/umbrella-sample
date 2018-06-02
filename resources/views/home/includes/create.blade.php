@php
    /**
     * Created by PhpStorm.
     * User: aRosen_LN
     * Date: 31.05.2018
     * Time: 1:21
     */
@endphp

@section('create')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('home.createLinksBlockHeader') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="create-url-form" method="post" action="{{route('home.create')}}">
                                {{csrf_field()}}
                                <div class="form-group required">
                                    <label class="control-label" for="origin-url">{{ __('home.originUrlLabel') }}</label>
                                    <input type="url" class="form-control" name="origin_url" id="origin-url" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="short-url">{{ __('home.shortUrlLabel') }}</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">{{ \App\Helpers\Helper::getShortUrlPrefix() }}/</div>
                                            </div>
                                            <input type="text" class="form-control" name="short_url" id="short-url">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-primary btn-block" id="generate-short-url-button">{{ __('home.generateButtonLabel') }}</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('home.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@show