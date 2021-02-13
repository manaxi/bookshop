@extends('layouts.admin')
@section('page_title')
    Genres
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Genres</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm" type="button"
                                    data-toggle="modal" data-target="#CreateGenreModal">
                                Add Genre
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th width="150" class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Create Genre Modal -->
    <div class="modal" id="CreateGenreModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Genre Create</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Genre was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitCreateGenreForm">Create</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Genre Modal -->
    <div class="modal" id="EditGenreModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Genre Edit</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Genre was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditGenreModalBody">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditGenreForm">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Genre Modal -->
    <div class="modal" id="DeleteGenreModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Genre Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Genre was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <h4>Are you sure want to delete this Genre?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="SubmitDeleteGenreForm">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // init datatable.
            var dataTable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 5,
                // scrollX: true,
                "order": [[0, "desc"]],
                ajax: '{{ route('admin.genres.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'title'},
                    {data: 'actions', name: 'actions', orderable: false, serachable: false, sClass: 'text-center'},
                ]
            });

            // Create Genre Ajax request.
            $('#SubmitCreateGenreForm').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.genres.store') }}",
                    method: 'post',
                    data: {
                        name: $('#name').val(),
                    },
                    success: function (result) {
                        if (result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('.datatable').DataTable().ajax.reload();
                            setInterval(function () {
                                $('.alert-success').hide();
                                $('#CreateGenreModal').modal('hide');
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });

            // Get single Genre in EditModel
            $('.modelClose').on('click', function () {
                $('#EditGenreModal').hide();
            });
            var id;
            $('body').on('click', '#getEditGenreData', function (e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "genres/" + id + "/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function (result) {
                        console.log(result);
                        $('#EditGenreModalBody').html(result.html);
                        $('#EditGenreModal').show();
                    }
                });
            });

            // Update Genre Ajax request.
            $('#SubmitEditGenreForm').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "genres/" + id,
                    method: 'PUT',
                    data: {
                        name: $('#editTitle').val(),
                    },
                    success: function (result) {
                        if (result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('.datatable').DataTable().ajax.reload();
                            setInterval(function () {
                                $('.alert-success').hide();
                                $('#EditGenreModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

            // Delete Genre Ajax request.
            var deleteID;
            $('body').on('click', '#getDeleteId', function () {
                deleteID = $(this).data('id');
            })
            $('#SubmitDeleteGenreForm').click(function (e) {
                e.preventDefault();
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "genres/" + id,
                    method: 'DELETE',
                    success: function (result) {
                        if (result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                            });
                        } else {
                            $('.datatable').DataTable().ajax.reload();
                            setInterval(function () {
                                $('.alert-success').hide();
                                $('#DeleteGenreModal').hide();
                                location.reload();
                            }, 1000);
                        }
                    }
                });
            });
        });
    </script>
@endsection
