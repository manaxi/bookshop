@extends('layouts.app')
@section('page_title') Edit book @endsection
@section('content')
    <div class="container p-5">
        <a href="{{ url()->previous() }}" class="btn btn-secondary pull-right"> <i class="fas fa-arrow-left"></i> Go
            Back</a>
        <h1 class="h3 mb-3">Your review for {{$review->book->title}} book</h1>
        <form method="POST" action="{{route('reviews.update', $review->id)}} " enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-label for="review" :value="__('Review')"/>
            <x-textarea id="review" name="review" value="{{$review->review}}" type="textarea"/>
            <x-submit-button buttonLabel="Submit"></x-submit-button>
        </form>
    </div>
@endsection
