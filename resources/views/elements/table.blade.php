@php
    /**
    *
    * @var array  $headings
    * @var array  $rowsData
    * @var string $header
    * @var string $tableName
    *
    **/
@endphp

@if($headings)
    <div id="{{$tableName}}" class="table-responsive">
        <p><strong>{{ $header }}</strong></p>
        <table class="table table-hover">
            <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading  }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if($rowsData)
                @foreach($rowsData as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>{!! $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{{__('home.recordsNotFound')}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endif