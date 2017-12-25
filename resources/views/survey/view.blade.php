@extends('layout.full')

@section('content')
    <div class="ui grid container">
        <div class="sixteen wide column">
            {!! Form::open(['route' => ['survey.answer', $survey], 'class'=> 'ui form', 'id' => 'answer-form']) !!}
            <div class="ui grid container">
                <div class="four wide column">
                    <img class="ui medium image"
                         src="{{ $survey->attachment != null ? route('survey.preview', $survey) : asset('assets/img/default.png') }}">
                </div>
                <div class="six wide column">
                    <h4 class="ui dividing header">Survey Title</h4>
                    <p>{{ $survey->title }}</p>
                    <h4 class="ui dividing header">Survey Description</h4>
                    <p>{{ $survey->description }}</p>
                    <h4 class="ui dividing header">Type of Survey</h4>
                    <p>{{ \App\Survey::TYPES[$survey->type] }}</p>
                </div>
                <div class="six wide column">
                    @if($survey->type == \App\Survey::TYPE_RESTRICT)
                        <h4 class="ui dividing header">Employees</h4>
                        <ul class="ui list">
                            @foreach($survey->employees as $employee)
                                <li>{{ $employee->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <h4 class="ui dividing header">Period of Survey</h4>
                    <p><strong>{{ $survey->start_at->format('Y-m-d') }}</strong> to
                        <strong>{{ $survey->end_at->format('Y-m-d') }}</strong></p>
                </div>
                @if(Carbon\Carbon::now()->gte( $survey->start_at->copy()->startOfDay() ) && Carbon\Carbon::now()->lte( $survey->end_at->copy()->endOfDay() ))
                    <div class="sixteen wide column">
                        <div class="error-container" style="display:none;"></div>
                        <div class="success-container" style="display:none;"></div>
                        <h4 class="ui dividing header">Questions</h4>
                        @foreach($survey->questions as $q)
                            <div class="field">
                                {!! Form::label('answers['.$q->id.']', $q->question) !!}
                                @switch($q->type)
                                    @case(\App\SurveyQuestion::TYPE_TEXT)
                                    {!! Form::text('answers['.$q->id.']', null, ['placeholder' => 'Your answer', 'required']) !!}
                                    @break
                                    @case(\App\SurveyQuestion::TYPE_NUMBER)
                                    {!! Form::number('answers['.$q->id.']', null, ['placeholder' => 'Your answer', 'required']) !!}
                                    @break
                                    @case(\App\SurveyQuestion::TYPE_SELECT)
                                    {!! Form::select('answers['.$q->id.']', explode('|', $q->options), null, ['required']) !!}
                                    @break
                                @endswitch
                            </div>
                        @endforeach

                        {!! Form::button('Back', ['class' => 'ui button', 'onclick' => 'history.back();return false;']) !!}
                        {!! Form::submit('Submit', ['class' => 'ui button primary']) !!}
                    </div>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('body_end')
    @parent
    <script type="text/javascript" src="{{ asset('assets/js/answer.js') }}"></script>
@endsection
