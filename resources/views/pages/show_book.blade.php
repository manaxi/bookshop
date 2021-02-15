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
                                @foreach($book->authors as $author)
                                    {{$author->name}}
                                @endforeach
                                <h6>
                                    @foreach($book->genres as $genre)
                                        {{$genre->name}}
                                    @endforeach
                                </h6>
                                <div class="rating-wrap pull-right">
                                    <form id="addStar" action="{{route('ratingStore')}}" method="POST">
                                        <input class="star star-5" value="5" id="star-5" type="radio" name="star"/>
                                        <input type="hidden" name="id" id="name" value="{{ $book->id}}">
                                        <label class="star star-5" for="star-5"></label>
                                        <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                                        <label class="star star-4" for="star-4"></label>
                                        <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                                        <label class="star star-3" for="star-3"></label>
                                        <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                                        <label class="star star-2" for="star-2"></label>
                                        <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                                        <label class="star star-1" for="star-1"></label>
                                    </form>
                                </div>
                                <div class="mb-3">
                                    @if($book->sale_price > 0)
                                        <span class="price h4">${{$book->discounted_price}}</span>
                                        <span class="price h6">old price {{$book->price}} </span>
                                    @else
                                        <span class="price h4">{{$book->price}} </span>
                                    @endif
                                </div>
                                {!! $book->description !!}
                                <hr>
                            </article>
                            @if(Auth::check())
                                <button id="addReport" type="button" class="btn btn-primary mt-3 pull-right"
                                        data-toggle="modal"
                                        data-target="#reportModal">
                                    Report book
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
            <h4>Reviews</h4>
            <div class="col-md-12">
                @if(Auth::check())
                    {{ Form::open(['route' => ['reviews.store'], 'method' => 'POST']) }}
                    <div class="form-group row">
                        {{Form::label('review', 'Review')}}
                        {{Form::textarea('review', '', ['id' => 'editor', 'class' => 'form-control', 'placeholder' => 'Review text'])}}
                        {{ Form::hidden('book_id', $book->id) }}
                    </div>
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    {{ Form::close() }}
                @endif
            </div>
        </article>
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
                            <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                            <button id="editReview" type="button" class="btn btn-primary ml-3" data-toggle="modal"
                                    data-target="#reviewModal"
                                    data-id="{{ $review->id }}"
                                    data-review="{{$review->review}}">
                                Edit
                            </button>
                            <button class="btn btn-danger ml-3" type="submit">Delete</button>
                        </form>
                    @endif
                </div>
            </article>
        @endforeach
    </section>


    <!-- Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('reviews.update', 'test')}}" method="post">
                        {{method_field('patch')}}
                        {{csrf_field()}}
                        <input type="hidden" name="id" id="id" value="">
                        <div class="row">
                            <div class="form-group col-lg">
                                {{Form::label('review', 'Review')}}
                                {!! Form::textarea('review', null, array('id'=> 'review', 'placeholder' => 'Review','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    {{ Form::open(['route' => ['reports.store'], 'method' => 'POST']) }}
                    <div class="form-group col-lg">
                        {{Form::label('review', 'Review')}}
                        {{Form::textarea('body', '', ['id' => 'editor', 'class' => 'form-control', 'placeholder' => 'Review text'])}}
                        {{ Form::hidden('book_id', $book->id) }}
                    </div>
                    <div class="modal-footer">
                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $('#addStar').change('.star', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                type: 'POST',
                cache: false,
                dataType: 'JSON',
                url: "{{route('ratingStore')}}",
                data: {
                    book_id: {{ $book->id }},
                    star: $('#name').val(),
                },
                success: function (data) {
                    console.log(data);
                }
            });
        });
        $('#reviewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id');
            var review = button.data('review');
            console.log(id);
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #review').val(review);
        });
        $('#reportModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id');
            console.log(id);
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

    </script>
@endsection
