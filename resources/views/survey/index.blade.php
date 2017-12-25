@extends('layout.full')

@section('content')
    <div class="ui grid">
        <div class="banner wide column sixteen">
            <p>Banner here</p>
        </div>
    </div>

    <div class="ui grid container">
        <div class="sixteen wide column">
            <h1 class="ui header">Open surveys <a class="ui button primary new-survey"
                                                  href="{{ route('survey.create') }}"><i
                            class="add square icon"></i> New survey</a></h1>
        </div>
    </div>

    <div class="ui grid container">
        @foreach($surveys as $survey)
            @include('survey.partial.open')
        @endforeach
    </div>
@endsection