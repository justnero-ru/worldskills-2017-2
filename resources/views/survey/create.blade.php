@extends('layout.full')

@section('content')
    <div class="ui grid container">
        <div class="sixteen wide column">
            {!! Form::open(['route' => 'survey.store', 'class' => 'ui form', 'enctype' => 'multipart/form-data']) !!}
            <h4 class="ui dividing header">About Survey</h4>
            <div class="three fields">
                <div class="field">
                    {!! Form::label('identification', 'Identification') !!}
                    {!! Form::text('identification', null, ['placeholder' => 'Identification']) !!}
                    @if($errors->has('identification'))
                        <div class="field-error">{{ $errors->first('identification') }}</div>
                    @endif
                </div>
                <div class="field">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::text('password', '', ['placeholder' => 'Password']) !!}
                    @if($errors->has('password'))
                        <div class="field-error">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="field">
                    {!! Form::label('title', 'Survey Title') !!}
                    {!! Form::text('title', null, ['placeholder' => 'Survey Title']) !!}
                    @if($errors->has('title'))
                        <div class="field-error">{{ $errors->first('title') }}</div>
                    @endif
                </div>
            </div>
            <div class="field">
                {!! Form::label('description', 'Survey Description') !!}
                {!! Form::textarea('description', null, ['placeholder' => 'Survey Description', 'rows' => 2]) !!}
                @if($errors->has('description'))
                    <div class="field-error">{{ $errors->first('description') }}</div>
                @endif
            </div>
            <div class="field">
                {!! Form::label('type', 'Type of Survey') !!}
                {!! Form::select('type', \App\Survey::TYPES) !!}
                @if($errors->has('type'))
                    <div class="field-error">{{ $errors->first('type') }}</div>
                @endif
            </div>

            <div class="ui cards filters_card" style="display: none">
                <div class="card card-employees">
                    <div class="content">
                        <div class="header">Employees Access</div>
                        <div class="two fields create_filters">
                            <div class="field">
                                {!! Form::label('filter_name', 'Filter by Name') !!}
                                {!! Form::text('filter_name', null, ['placeholder' => 'Filter by Name']) !!}
                            </div>

                            <div class="field">
                                {!! Form::label('filter_company', 'Filter by Company') !!}
                                {!! Form::text('filter_company', null, ['placeholder' => 'Filter by Company']) !!}
                            </div>
                        </div>

                        <div class="description">
                            <h4 class="ui dividing header">Employees</h4>
                            <div class="filters_list">
                                @foreach($employees as $employee)
                                    <div class="item" id="filter_block_{{ $employee->id }}"
                                         data-name="{{ strtolower($employee->name) }}"
                                         data-company="{{ strtolower($employee->partners->isEmpty() ? '' : $employee->partners->first()->companyName) }}">
                                        <div class="content">
                                            <div class="ui checkbox">
                                                <input type="checkbox" name="filter[{{ $employee->id }}]"
                                                       id="filter_{{ $employee->id }}" value="true"
                                                       @if(old('filter.'.$employee->id)) checked @endif>
                                                <label for="filter_{{ $employee->id }}">{{ $employee->name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if($errors->has('filter'))
                        <div class="field-error">{{ $errors->first('filter') }}</div>
                    @endif
                </div>
            </div>

            <div class="field">
                {!! Form::label('attachment', 'Attached File') !!}
                {!! Form::file('attachment') !!}
                @if($errors->has('attachment'))
                    <div class="field-error">{{ $errors->first('attachment') }}</div>
                @endif
            </div>
            <div id="attachment_preview"><img src="" alt="Preview"></div>
            <h4 class="ui dividing header">Period of Survey</h4>
            <div class="two fields">
                <div class="field">
                    {!! Form::label('start_at', 'Start Date') !!}
                    {!! Form::date('start_at', null, ['placeholder' => 'Start Date']) !!}
                    @if($errors->has('start_at'))
                        <div class="field-error">{{ $errors->first('start_at') }}</div>
                    @endif
                </div>
                <div class="field">
                    {!! Form::label('end_at', 'End Date') !!}
                    {!! Form::date('end_at', null, ['placeholder' => 'End Date']) !!}
                    @if($errors->has('end_at'))
                        <div class="field-error">{{ $errors->first('end_at') }}</div>
                    @endif
                </div>
            </div>
            <h4 class="ui dividing header">Questions
                <span>{!! Form::button('<i class="add square icon"></i> New question', ['class' => 'ui button new-question']) !!}</span>
            </h4>
            <div class="question_list" data-types="{{ json_encode(\App\SurveyQuestion::TYPES) }}">
                @foreach(old('question') ?? [] as $i => $q)
                    <div class="three fields question">
                        <div class="field">
                            <label for="question_{{ $i }}_question">Question</label>
                            <input type="text" name="question[{{ $i }}][question]" id="question_{{ $i }}_question"
                                   placeholder="Question" value="{{ $q['question'] }}">
                            @if($errors->has('question.'.$i.'.question'))
                                <div class="field-error">{{ $errors->first('question.'.$i.'.question') }}</div>
                            @endif
                        </div>
                        <div class="field">
                            <label for="question_{{ $i }}_type">Type of Answer</label>
                            <select name="question[{{ $i }}][type]" id="question_{{ $i }}_type"
                                    placeholder="Type of Answer">
                                @foreach(\App\SurveyQuestion::TYPES as $k => $v)
                                    <option value="{{ $k }}" @if($k == $q['type']) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('question.'.$i.'.type'))
                                <div class="field-error">{{ $errors->first('question.'.$i.'.type') }}</div>
                            @endif
                        </div>
                        <div class="field">
                            <label for="question_{{ $i }}_options">Options List</label>
                            <input type="text" name="question[{{ $i }}][options]" id="question_{{ $i }}_options"
                                   placeholder="Options List" value="{{ $q['options'] }}">
                            @if($errors->has('question.'.$i.'.options'))
                                <div class="field-error">{{ $errors->first('question.'.$i.'.options') }}</div>
                            @endif
                        </div>
                        <div class="field">
                            <button class="ui red button remove-question"><i class="remove icon"></i> Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>

            {!! Form::button('Back', ['class' => 'ui button', 'onclick' => 'history.back();return false;']) !!}
            {!! Form::submit('Submit', ['class' => 'ui button primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('body_end')
    @parent
    <script type="text/javascript" src="{{ asset('assets/js/create.js') }}"></script>
@endsection
