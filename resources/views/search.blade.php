@extends('app')

@section('content')
    <div class="container">
    @forelse($cases as $case)
        <div class="row">
            <div class="col-md-3">
                <p>{{ $case->getData() }}</p>
            </div>
            <div class="col-md-9">
                @foreach($case->getLinks() as $link)
                    <a href="{{ $link->getUrl()  }}"><img src="{{ $link->getUrl() }}?0+0+150+0" /></a>
                @endforeach
            </div>
        </div>

    @empty

    @endforelse
    </div>
@endsection
