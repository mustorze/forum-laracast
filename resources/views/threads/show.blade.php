@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profiles.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </span>

                            @can ('update', $thread)

                                <form class="" action="{{ $thread->path() }}" method="post">

                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>

                            @endcan

                        </div>

                    </div>

                    <replies :data="{{ $threads->replies }}"></replies>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                {{-- </div>

                @foreach ($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }} --}}

                @if (auth()->check())

                    <form action="{{ $thread->path() . '/replies' }}" method="POST">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default" name="button">Post</button>

                    </form>

                @else

                    <p class="text-center">Please <a href=" {{ route('login') }} ">sign in</a> to participate in this discussion.</p>

                @endif

            </div>

            <div class="col-md-4">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ route('profiles.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
