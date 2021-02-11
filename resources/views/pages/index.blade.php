@extends('layouts.app')
@section('page_title')Home page @endsection
@section('content')
    <h1 class="mt-5">Books list</h1>
    <div class="row ">
        @if(count($books) > 0)
            @foreach($books as $book)
                <div class="ml-4" style="width: 12rem;">
                    <img class="card-img-top" src="/storage/cover_images/{{$book->cover_image}}" alt=""/>
                    <div class="card-body">
                        <h5 class="card-title">{{$book->title}}</h5>
                        <p class="card-text">
                            @foreach($book->authors as $author)
                                @if($loop->first)
                                    {{$author->name}}
                                @endif
                            @endforeach
                        </p>
                        <a href="" class="btn btn-primary">${{$book->price}}</a>
                    </div>
                </div>
            @endforeach
            {{$books->links()}}
        @else
            <p>No books found</p>
        @endif
    </div>
@endsection
