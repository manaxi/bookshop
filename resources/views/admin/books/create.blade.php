@extends('layouts.admin')
@section('page_title')
    Create book
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add book to listing</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(array('route' => 'admin.books.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                            <div class="form-group">
                                {{Form::label('title', 'Title')}}
                                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                                <p class="help-block"></p>
                                @if($errors->has('title'))
                                    <p class="help-block">
                                        {{ $errors->first('title') }}
                                    </p>
                                @endif
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    {{Form::label('price', 'Price')}}
                                    {{Form::text('price', '', ['class' => 'form-control', 'placeholder' => 'Price'])}}
                                    <p class="help-block"></p>
                                    @if($errors->has('price'))
                                        <p class="help-block">
                                            {{ $errors->first('price') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    {{Form::label('sale_price', 'Sale price')}}
                                    {{Form::text('sale_price', '', ['class' => 'form-control', 'placeholder' => 'Price'])}}
                                    <p class="help-block"></p>
                                    @if($errors->has('sale_price'))
                                        <p class="help-block">
                                            {{ $errors->first('sale_price') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    {!! Form::label('authors', 'Authors (separated by comma)', ['class' => 'control-label']) !!}
                                    {{Form::text('authors', '', ['class' => 'form-control', 'placeholder' => 'Authors'])}}
                                    <p class="help-block"></p>
                                    @if($errors->has('authors'))
                                        <p class="help-block">
                                            {{ $errors->first('authors') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('genres', 'Genres', ['class' => 'control-label']) !!}
                                    {!! Form::select('genres[]', $genres, old('genres'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'selectall-genre' ]) !!}
                                    <p class="help-block"></p>
                                    @if($errors->has('genre'))
                                        <p class="help-block">
                                            {{ $errors->first('genres') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('description', 'Description')}}
                                {{Form::textarea('description', '', ['id' => 'editor', 'class' => 'form-control', 'placeholder' => 'Description Text'])}}
                            </div>


                            <div class="form-group">
                                {{Form::file('cover_image')}}
                            </div>
                            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
@section('script')
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endsection
