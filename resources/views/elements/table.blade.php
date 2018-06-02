@php
    /**
    *
    * @var array  $headings
    * @var array  $rowsData
    * @var string $header
    *
    **/
@endphp

@if($headings)
    <div class="table-responsive">
        <strong>{{ $header }}</strong>
        <table class="table">
            <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading  }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($rowsData as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif