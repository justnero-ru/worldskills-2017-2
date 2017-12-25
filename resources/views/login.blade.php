@extends('layout.brief')

@section('content')
    <div class="ui middle aligned center aligned grid">
        <div class="column column-login">
            <h2 class="ui teal image header">
                <img src="{{ asset('assets/img/logo.jpg') }}" class="image">
                <span class="content">
                    Log-in to access the restrict survey
                </span>
            </h2>

            {!! Form::open(['route' => ['survey.manage-auth', $survey], 'class' => 'ui large form', 'id' => 'login-form']) !!}
            <div class="error-container" style="display:none;"></div>
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="envelope icon"></i>
                        <input type="text" name="email" placeholder="E-mail address">
                    </div>
                </div>
                <button type="submit" class="ui fluid large teal submit button">Access</button>
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
