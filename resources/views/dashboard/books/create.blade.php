@extends('layouts.app')
@section('page_title')Create book @endsection
@section('content')
    <div class="container p-5">
        <h1 class="h3 mb-3">Add book to listing</h1>
        <form action="{{ route('dashboard.books.store')}} " method="POST" enctype="multipart/form-data">
            @csrf
            <x-label for="genre" :value="__('Title')"/>
            <x-input id="title" name="title" placeholder="Title" :value="old('title')" type="text"/>
            <div class="row">
                <div class="col-sm-6">
                    <x-label for="Price" :value="__('Price')"/>
                    <x-input id="price" name="price" placeholder="Price" :value="old('price')" type="number"/>
                </div>
                <div class="col-sm-6 pl-5">
                    <x-label for="discount" :value="__('Discount %')"/>
                    <x-input id="sale_price" name="sale_price" placeholder="Discount" :value="old('sale_price')"
                             type="number"/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <x-label for="Authors" :value="__('Authors (seperated by comma)')"/>
                    <x-input id="authors" name="authors" placeholder="Authors" :value="old('authors')" type="text"/>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row pl-4">
                        <x-label for="Genres" :value="__('Genres')"/>
                        <select name="genres[]" id="genres" class="form-control select2" multiple="multiple">
                            @forelse($genres as $genre)
                                <option value="{{$genre->id}}" {{ old('genres') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                @empty
                                <option>No genres</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
            <x-label for="description" :value="__('Book description')"/>
            <x-textarea id="description" name="description" :value="old('description')" type="textarea"/>
            <x-file-group fieldLabel="" fieldName="cover_image" fieldType="file"/>
            <x-submit-button buttonLabel="Submit"></x-submit-button>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endsection
