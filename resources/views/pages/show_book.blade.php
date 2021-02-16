@extends('layouts.app')
@section('page_title')  {{$book->title}} @endsection
@section('content')
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row no-gutters">
                        <aside class="col-md-4">
                            <article class="gallery-wrap">
                                <img class="card-img" src="/storage/cover_images/{{$book->cover_image}}" alt=""/>
                            </article>
                        </aside>
                        <main class="col-md-8 pl-4">
                            <article>
                                <h2 class="title">{{$book->title}}</h2>
                                <hr>
                                <div class="rating-wrap pull-right">
                                    @if(Auth::check())
                                        <div id="app">
                                            <rating
                                                :user_rating="@if(isset($book->rating->rate)) {{$book->rating->rate}} @else 0  @endif"
                                                :book_id="{{$book->id}}" :user_id="{{auth()->id()}}"></rating>
                                        </div>
                                        <span>Average rating: {{$book->avg_rating}}</span>
                                    @else
                                        <span>Average book rating: {{$book->avg_rating}}</span>
                                    @endif
                                </div>
                                @foreach($book->authors as $author)
                                    {{$author->name}}
                                @endforeach
                                <h6>
                                    @foreach($book->genres as $genre)
                                        {{$genre->name}}
                                    @endforeach
                                </h6>
                                <div class="mb-3">
                                    @if($book->sale_price > 0)
                                        <span class="price h4">${{$book->discounted_price}}</span>
                                        <span class="price h6">old price {{$book->price}} </span>
                                    @else
                                        <span class="price h4">{{$book->price}} </span>
                                    @endif
                                </div>
                                {{$book->description}}
                                <hr>
                            </article>
                            @if(Auth::check())
                                <button id="addReport" type="button" class="btn btn-primary mt-3 pull-right"
                                        data-toggle="modal"
                                        data-target="#reportModal">Report book
                                </button>
                            @endif
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="reviews col-md-12 mt-3">
        <article class="mb-3">
            <div class="col-md-12">
                @if(Auth::check())
                    <form action="{{ route('reviews.store')}} " method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-label for="description" :value="__('Write review')"/>
                        <x-textarea id="review" name="review" :value="old('review')" type="textarea"/>
                        <x-input id="book_id" name="book_id" value="{{$book->id}}" type="hidden"/>
                        <x-submit-button buttonLabel="Submit"></x-submit-button>
                    </form>
                @endif
            </div>
        </article>
        <h4>Reviews</h4>
        @foreach($book->reviews as $review)
            <article class="mb-3">
                <div class="text">
                    <h6><i class="fas fa-user"></i> {{$review->user->name}}
                        <span class="date text-muted">
                        <i class="fas fa-calendar"></i> {{$review->created_at}}
                    </span>
                    </h6>
                </div>
                <div class="row">
                    <div class="col-sm-10 mt-3">
                        <p>{{$review->review}}</p>
                    </div>
                    @if($review->user_id == auth()->id())
                        <form action="{{ route('reviews.destroy', $review->id)}}" method="post"
                              onsubmit="return confirm('Are your sure?');">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('reviews.edit', $review->id)}}" class="btn btn-primary">Edit</a>
                            <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                            <button class="btn btn-danger ml-3" type="submit">Delete</button>
                        </form>
                    @endif
                </div>
            </article>
        @endforeach
    </section>

    <!-- Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reports.store')}} " method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-label for="description" :value="__('Report book')"/>
                        <x-textarea id="body" name="body" :value="old('body')" type="textarea"/>
                        <x-input id="book_id" name="book_id" value="{{$book->id}}" type="hidden"/>
                        <x-submit-button buttonLabel="Submit"></x-submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $('#reportModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id');
            console.log(id);
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endsection
