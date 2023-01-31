@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="row g-3" method="post" action="/books" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="book_id" value="{{$book['id']}}">
            <div class="col-md-6">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{old('title') ?? $book['title']}}">
                @error('title')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" class="form-control" id="author" value="{{old('author') ?? $book['author']}}">
                @error('author')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-6">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" name="genre" class="form-control" id="genre" value="{{old('genre') ?? $book['genre']}}">
                @error('genre')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="isbn" class="form-label">isbn</label>
                <input type="text" name="isbn" class="form-control" id="isbn" value="{{old('isbn') ?? $book['isbn']}}">
                @error('isbn')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-6">
                <label for="file" class="form-label">Description</label>
                <textarea type="text" name="description" class="form-control" id="description">{{old('description') ?? $book['description']}}</textarea>
                @error('description')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-6">
                <label for="book_image" class="form-label">Image</label>
                <input type="file" name="book_image" class="form-control" id="book_image" accept="image/*">
                @error('book_image')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="published" class="form-label">published on</label>
                <input type="date" name="published" class="form-control" id="published" value="{{old('published') ?? $book['published']}}">
                @error('published')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            @if($book['image'])
            <div class="col-md-6">
                <div>Present Image</div>
                @if($local_storage)
                    <img src="{{asset('public/storage/book-images/'.$book['image'])}}" width="100"/>
                @else
                    <img src="{{$book['image']}}" width="100"/>
                @endif
            </div>
            @endif
            <div class="col-md-6">
                <label for="publisher" class="form-label">Publisher</label>
                <input type="text" name="publisher" class="form-control" id="publisher" value="{{old('publisher') ?? $book['publisher']}}">
                @error('publisher')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-12">
                <a href="/home" class="btn btn-secondary">Go Back</a>
                <button type="submit" class="btn btn-primary m-lg-2">{{!$book['id']?'Add Book':'Update'}}</button>
            </div>

        </form>
    </div>
@endsection
