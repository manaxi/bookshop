@extends('layouts.app')
@section('page_title')  {{$book->title}} @endsection
@section('content')
    <div class="blog-post py-5">
        <h2 class="blog-post-title">{{$book->title}}
            @if($current_dateTime <= $book->created_at)
                <span class="badge badge-primary">NEW</span>
            @endif
        </h2>
        <div class="row">
            <div class="blog-post-image col-sm-3">
                <img style="width:288px; height: 430px;"
                     class="card-img-right img-fluid flex-auto d-none d-md-block rounded"
                     src="/storage/cover_images/{{$book->cover_image}}"
                     alt=""/>
            </div>
            <div class="blog-post-text col-sm-2">
                <h5>
                    <span class="price">${{ $book->price }}</span>
                </h5>
                {!!$book->description!!}
            </div>
        </div>
    </div>
    </div>

@endsection
