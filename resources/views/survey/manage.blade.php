@extends('layout.full')

@section('content')
    <div class="ui grid container">
        <div class="sixteen wide column">
            <div class="ui form">
                <div class="ui grid container">
                    <div class="four wide column">
                        <img class="ui medium image"
                             src="{{ $survey->attachment != null ? route('survey.preview', $survey) : asset('assets/img/default.png') }}">
                    </div>
                    <div class="six wide column">
                        <h4 class="ui dividing header">Identification</h4>
                        <p>{{ $survey->identification }}</p>
                        <h4 class="ui dividing header">Survey Title</h4>
                        <p>{{ $survey->title }}</p>
                        <h4 class="ui dividing header">Survey Description</h4>
                        <p>{{ $survey->description }}</p>
                        {!! Form::open(['route' => ['survey.manage_delete', $survey->identification], 'id' => 'delete-form']) !!}
                        {!! Form::submit('Delete', ['class' => 'ui button negative']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="six wide column">
                        <h4 class="ui dividing header">Type of Survey</h4>
                        <p>{{ \App\Survey::TYPES[$survey->type] }}</p>
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
                    <table class="report">
                        <thead>
                        <tr>
                            @foreach($survey->questions as $q)
                                <th>{{ $q->question }}</th>
                            @endforeach
                            <th>Date & time</th>
                            <th>IP address</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($survey->answers as $ans)
                            <tr>
                                @foreach($survey->questions as $q)
                                    <td>{{ $ans->answers[$q->id] }}</td>
                                @endforeach
                                <td>{{ $ans->created_at->format('Y/m/d H:i:s') }}</td>
                                <td>{{ $ans->ip }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="{{ 2 + $survey->questions->count() }}">Report generated
                                at {{ Carbon\Carbon::now()->format('Y/m/d H:i:s') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body_end')
    @parent
    <script type="text/javascript" src="{{ asset('assets/js/manage.js') }}"></script>
@endsection
