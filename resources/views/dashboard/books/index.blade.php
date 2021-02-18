@extends('layouts.app')
@section('page_title') My book @endsection
@section('content')
    <h1 class="mt-5">My books</h1>
    <a class="btn btn-primary" href="{{route('dashboard.books.create')}}" role="button">Add book</a>
    <div class="row">
        @forelse($books as $book)
            <div class="mt-3 ml-4" style="width: 12rem;">
                @if($book->status)
                    Status: <i class="fas fa-check fa-1x text-success"></i>
                @else
                    Status: <i class="fas fa-ban fa-1x text-danger"></i>
                @endif
                <div class="card-books-grid">
                    <div class="img-wrap">
                        @if($book->is_new)
                            <span class="badge badge-primary">NEW</span>
                        @else
                            <span class="badge badge-primary"></span>
                        @endif
                        @if($book->sale_price > 0)
                            <div class="discount-icon">
                                <span class="badge badge-primary pt-8">-%{{$book->sale_price}}</span>
                            </div>
                        @endif
                        <a href="{{route('books.show', $book->slug)}}"><img class="card-img-top"
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
                        <div class="status">

                        </div>
                        <div class="actions">
                            <div class="pull-left">
                                <a href="{{ route('dashboard.books.edit', $book) }}" class="btn btn-secondary">Edit</a>
                            </div>
                            <div class="pull-right">
                                <form action="{{ route('dashboard.books.destroy', $book->id) }}" method="POST"
                                      onsubmit="return confirm('Are your sure?');"
                                      style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn  btn-danger" value="Delete">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No books found</p>
        @endforelse
    </div>
    <div class="row justify-content-md-center mt-4">
        {{$books->links()}}
    </div>
@endsection

@section('script')
@endsection


