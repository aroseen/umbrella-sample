@php
    /**
     * Created by PhpStorm.
     * User: aRosen_LN
     * Date: 31.05.2018
     * Time: 1:21
     *
     * @var array $ownLinksTableContent
     * @var array $getSharedTableContent
     * @var array $ownLinksTableContent
     *
     */
@endphp

@section('links')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('home.linksBlockLabel') }}</div>
                <div class="card-body">
                    @include('elements.table', [
                        'tableName' => $ownLinksTableContent['tableName'],
                        'header'    => __('home.selfLinksLabel'),
                        'headings'  => $ownLinksTableContent['headings'],
                        'rowsData'  => $ownLinksTableContent['data'],
                    ])
                    @include('elements.table', [
                        'tableName' => $getSharedTableContent['tableName'],
                        'header'    => __('home.availableLinksLabel'),
                        'headings'  => $getSharedTableContent['headings'],
                        'rowsData'  => $getSharedTableContent['data']
                    ])
                    @include('elements.table', [
                        'tableName' => $sharedLinksTableContent['tableName'],
                        'header'    => __('home.sharedLinksLabel'),
                        'headings'  => $sharedLinksTableContent['headings'],
                        'rowsData'  => $sharedLinksTableContent['data']
                    ])
                </div>
            </div>
        </div>
    </div>
@show