@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">

                    <avatar-form :user="{{ $profileUser }}"></avatar-form>

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
