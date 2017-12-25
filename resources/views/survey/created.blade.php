@extends('layout.brief')

@section('content')
    <div class="ui middle aligned center aligned grid">
        <div class="column column-login">
            <h2 class="ui teal image header">
                <img src="{{ asset('assets/img/logo.jpg') }}" class="image">
                <span class="content">
                    Survey was created
                </span>
            </h2>

            <div class="ui stacked segment">
                <h3>You can manage it at:</h3>
                <a href="{{ route('survey.manage', $survey) }}"
                   class="ui fluid large teal submit button">{{ route('survey.manage', $survey) }}</a>
            </div>
        </div>
    </div>
@endsection