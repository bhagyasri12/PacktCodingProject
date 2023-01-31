@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="d-flex justify-content-end mb-3">
                <a href="/customer-view" class="btn btn-primary mx-2">Open Customer view</a>
                <a href="/books/create" class="btn btn-primary">Add Book</a>
            </div>
            <div>
                <books-component></books-component>
            </div>
        </div>
    </div>
@endsection
