@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">

                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>

                    @can('update', $profileUser)
                        <form method="POST" action="/api/users/{{ $profileUser->id }}/avatar" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="avatar" type="file">

                            <button type="submit" class="btn btn-primary">Add Avatar</button>
                        </form>
                    @endcan

                    <img src="{{ asset('storage/' . $profileUser->avatar_path) }}" alt="" width="50">

                </div>

                @forelse ($activities as $date => $activity)
                    <h3>{{ $date }}</h3>
                    <hr>
                    @foreach ($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty

                    <p>There is no activity for this user yet.</p>

                @endforelse

                {{--{{ $threads->links() }}--}}
            </div>
        </div>
    </div>

@endsection
