@php
    /**
     * Created by PhpStorm.
     * User: aRosen_LN
     * Date: 31.05.2018
     * Time: 1:21
     */
@endphp

@section('settings')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('home.settingsBlockLabel') }}</div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="shareCheckbox">
                        <label class="form-check-label" for="shareCheckbox">{{ __('home.activateSharesCheckboxLabel') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@show