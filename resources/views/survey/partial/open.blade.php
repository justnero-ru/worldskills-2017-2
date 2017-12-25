<div class="four wide column">
    <div class="ui card">
        <div class="image">
            <img src="{{ $survey->attachment != null ? route('survey.preview', $survey) : asset('assets/img/default.png') }}">
        </div>
        <div class="content">
            <a href="{{ route('survey.view', $survey) }}" class="header">{{ $survey->title }}</a>
            <div class="meta">
                <span class="date"><strong>{{ $survey->start_at->format('Y-m-d') }}</strong> to <strong>{{ $survey->end_at->format('Y-m-d') }}</strong></span>
            </div>
        </div>
        <div class="extra content">
            <i class="check icon"></i>
            {{ $survey->answers()->count() }} Completed surveys
        </div>
    </div>
</div>