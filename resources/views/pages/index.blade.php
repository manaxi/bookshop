@extends('layouts.app')
@section('page_title')Home page @endsection
@section('content')
    <h1 class="mt-5">Books list</h1>
    <div class="row ">
        @if(count($books) > 0)
            @foreach($books as $book)
                <div class="ml-4" style="width: 12rem;">
                    <div class="card-books-grid">
                        <div class="img-wrap">
                            @if($current_dateTime <= $book->created_at)
                                <span class="badge badge-primary">NEW</span>
                            @else
                                <span class="badge badge-primary"></span>
                            @endif
                            @if($book->sale_price > 0)
                                <div class="discount-icon">
                                    <span class="badge badge-primary pt-8">-%{{$book->sale_price}}</span>
                                </div>
                            @endif
                            <a href="{{route('show_book', $book->id)}}}"><img class="card-img-top"
                                                                              src="/storage/cover_images/{{$book->cover_image}}"
                                                                              alt=""/></a>
                        </div>
                        <div class="info-wrap">
                            <h4 class="text-center">{{$book->title}}</h4>
                            <h6 class="card-text text-center">
                                @foreach($book->authors as $author)
                                    @if($loop->first)
                                        {{$author->name}}
                                    @endif
                                @endforeach
                            </h6>
                            <div class="price text-center">
                                <div class="mb-3">
                                    @if($book->sale_price >0)
                                        <span class="price h4">${{$book->discounted_price}}</span>
                                        <span class="price text-muted">${{$book->price}}</span>
                                        @else
                                        <span class="price h4">${{$book->price}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$books->links()}}
        @else
            <p>No books found</p>
        @endif
    </div>
@endsection
