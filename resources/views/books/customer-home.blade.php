@extends('layouts.app')

@section('content')

    @if(auth()->user()->is_admin)
    <a href="/home" class="mx-2 float-end mx-3">Back</a>
    @endif
    <div class="container">
        <div class="row">
            <customers-component></customers-component>
        </div>
    </div>
    </div>
@endsection
