@php
    /**
     * Created by PhpStorm.
     * User: aRosen_LN
     * Date: 31.05.2018
     * Time: 1:21
     */
@endphp

@section('links')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('home.linksBlockLabel') }}</div>
                <div class="card-body">
                    @include('elements.table', [
                        'header'   => __('home.selfLinksLabel'),
                        'headings' => ['First', 'Last', 'Handle', null],
                        'rowsData' => [
                            ['Mark', 'Otto', '@mdo', view('elements.share-table-button', [
                                'buttonText' => 'Расшарить',
                            ])],
                            ['Jacob', 'Thornton', '@fat', view('elements.share-table-button', [
                                'buttonText' => 'Расшарить',
                            ])],
                            ['Larry', 'The Bird', '@twitter', view('elements.share-table-button', [
                                'buttonText' => 'Расшарить',
                            ])],
                        ]
                    ])
                    @include('elements.table', [
                        'header'   => __('home.availableLinksLabel'),
                        'headings' => ['First', 'Last', 'Handle'],
                        'rowsData' => [
                            ['Mark', 'Otto', '@mdo'],
                            ['Jacob', 'Thornton', '@fat'],
                            ['Larry', 'The Bird', '@twitter'],
                        ]
                    ])
                    @include('elements.table', [
                        'header'   => __('home.sharedLinksLabel'),
                        'headings' => ['First', 'Last', 'Handle'],
                        'rowsData' => [
                            ['Mark', 'Otto', '@mdo', view('elements.share-table-button', [
                                'buttonText' => 'Отменить',
                            ])],
                            ['Jacob', 'Thornton', '@fat', view('elements.share-table-button', [
                                'buttonText' => 'Отменить',
                            ])],
                            ['Larry', 'The Bird', '@twitter', view('elements.share-table-button', [
                                'buttonText' => 'Отменить',
                            ])],
                        ]
                    ])
                </div>
            </div>
        </div>
    </div>
@show