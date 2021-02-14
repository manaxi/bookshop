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
                    <h1 class="m-0">Reply to user {{$report->user->name}} report</h1>
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
                            <h4>Report message:</h4>
                            <span>{{$report->body}}</span>
                            {!! Form::model($report, ['method' => 'PUT','route' => ['admin.reports.update', $report->id], 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group">
                                {{Form::label('Body', 'Answer')}}
                                {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Body'])}}
                                <p class="help-block"></p>
                                @if($errors->has('body'))
                                    <p class="help-block">
                                        {{ $errors->first('body') }}
                                    </p>
                                @endif
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
