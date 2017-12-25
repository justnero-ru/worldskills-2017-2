@extends('layout.brief')

@section('content')
    <div class="ui middle aligned center aligned grid">
        <div class="column column-login">
            <h2 class="ui teal image header">
                <img src="{{ asset('assets/img/logo.jpg') }}" class="image">
                <span class="content">
                    Log-in to manage survey
                </span>
            </h2>

            {!! Form::open(['route' => ['survey.manage_auth', $survey_slug], 'class' => 'ui large form', 'id' => 'auth-form']) !!}
            <div class="error-container" style="display:none;"></div>
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <input type="password" name="password" placeholder="Password">
                    </div>
                </div>
                <button type="submit" class="ui fluid large teal submit button">Login</button>
            </div>
            {!! Form::close() !!}

            <div class="ui message">
                New to us? <a href="#">Sign Up</a>
            </div>
        </div>
    </div>
@endsection

@section('body_end')
    @parent
    <script type="text/javascript" src="{{ asset('assets/js/login.js') }}"></script>
@endsection
