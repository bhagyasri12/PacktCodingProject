@extends('layouts.app')

@section('content')

    <div class="container">

        @if(auth()->user()->is_admin)
            <a href="/customer-view" class="mx-2 float-end mx-3">Back</a>
            @else
            <a href="/home" class="mx-2 float-end mx-3">Back</a>
        @endif

        <div class="row border border-1 container-fluid w-75 py-4">
            <div class="col-md-3">
                <img src="{{$book['image']}}" width="150" class="mb-3">
            </div>
            <div class="col-md-9">
                <div class="mb-1">
                    <span class="fw-bold">Title : </span>
                    <span class="">{{ $book['title'] }}</span>
                </div>
                <div class="mb-1">
                    <span class="fw-bold">Author : </span>
                    <span class="">{{ $book['author'] }}</span>
                </div>
                <div class="mb-1">
                    <span class="fw-bold">Description : </span>
                    <span class="">{{ $book['description'] }}</span>
                </div>
                <div class="mb-1">
                    <span class="fw-bold">genre : </span>
                    <span class="">{{ $book['genre'] }}</span>
                </div>
                <div class="mb-1">
                    <span class="fw-bold">isbn : </span>
                    <span class="">{{ $book['isbn'] }}</span>
                </div>
                <div class="mb-1">
                    <span class="fw-bold">Published : </span>
                    <span class="">{{ $book['published'] }}</span>
                </div>
                <div class="mb-1">
                    <span class="fw-bold">Publisher : </span>
                    <span class="">{{ $book['publisher'] }}</span>
                </div>
            </div>
        </div>
    </div>

@endsection
