@extends('layouts.app')
@section('page_title')Profile settings @endsection
@section('content')
    <div class="container p-5">
        <h1 class="h3 mb-3">Dashboard</h1>
        <a class="btn btn-primary" href="{{route('dashboard.books.create')}}" role="button">Add book</a>

        <h3>Your Books</h3>
        @if(count($user_books) > 0)
            <table class="table table-striped">
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Genre</th>
                </tr>
                @foreach($user_books as $book)
                    <tr>
                        <td><img src="/storage/cover_images/{{$book->cover_image}}" alt="" width="100" height="200"/>
                        </td>
                        <td>{{$book->title}}</td>
                        <td>
                            @foreach($book->authors as $author)
                                {{$author->name}} |
                            @endforeach
                        </td>
                        <td>
                            @foreach($book->genres as $genre)
                                {{$genre->name}} |
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <div class="d-flex justify-content-center">
                    {!! $user_books->links() !!}
                </div>
                @else
                    <p>No books found</p>
            </table>
        @endif
    </div>
@endsection


