@forelse ($threads as $thread)
    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="level">

                <div class="flex">
                    <h4 class="flex">
                        <a href="{{ $thread->path() }}">

                            @if(auth()->check() AND $thread->hasUpdatesFor(auth()->user()))

                                <strong>{{ $thread->title }}</strong>

                            @else

                                {{ $thread->title }}

                            @endif

                        </a>
                    </h4>

                    <h5>
                        Posted by:
                        <a href="/profiles/{{ $thread->creator->name }}">
                            {{ $thread->creator->name }}
                        </a>
                    </h5>
                </div>

                <strong><a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a></strong>

            </div>

        </div>

        <div class="panel-body">
            <div class="body">
                {!! $thread->body !!}
            </div>
        </div>

        <div class="panel-footer">
            {{ $thread->visits()->count() }} Visits.
        </div>
    </div>
@empty
    <p>There no relevant results at this time.</p>
@endforelse