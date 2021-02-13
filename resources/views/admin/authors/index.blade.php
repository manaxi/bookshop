@extends('layouts.admin')
@section('page_title')
    Authors
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Authors</h1>
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
                                    data-toggle="modal" data-target="#CreateAuthorModal">
                                Add Author
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
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

    <!-- Create Author Modal -->
    <div class="modal" id="CreateAuthorModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Author Create</h4>
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
                        <strong>Success!</strong>Author was added successfully.
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
                    <button type="button" class="btn btn-success" id="SubmitCreateAuthorForm">Create</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Author Modal -->
    <div class="modal" id="EditAuthorModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Author Edit</h4>
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
                        <strong>Success!</strong>Author was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditAuthorModalBody">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditAuthorForm">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Author Modal -->
    <div class="modal" id="DeleteAuthorModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Author Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4>Are you sure want to delete this Author?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="SubmitDeleteAuthorForm">Yes</button>
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
                ajax: '{{ route('admin.authors.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'title'},
                    {data: 'actions', name: 'actions', orderable: false, serachable: false, sClass: 'text-center'},
                ]
            });

            // Create Author Ajax request.
            $('#SubmitCreateAuthorForm').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.authors.store') }}",
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
                                $('#CreateAuthorModal').modal('hide');
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });

            // Get single Author in EditModel
            $('.modelClose').on('click', function () {
                $('#EditAuthorModal').hide();
            });
            var id;
            $('body').on('click', '#getEditAuthorData', function (e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "authors/" + id + "/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function (result) {
                        console.log(result);
                        $('#EditAuthorModalBody').html(result.html);
                        $('#EditAuthorModal').show();
                    }
                });
            });

            // Update Author Ajax request.
            $('#SubmitEditAuthorForm').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "authors/" + id,
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
                                $('#EditAuthorModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

            // Delete Author Ajax request.
            var deleteID;
            $('body').on('click', '#getDeleteId', function () {
                deleteID = $(this).data('id');
            })
            $('#SubmitDeleteAuthorForm').click(function (e) {
                e.preventDefault();
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "authors/" + id,
                    method: 'DELETE',
                    success: function (result) {
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function () {
                            $('.alert-success').hide();
                            $('#DeleteAuthorModal').hide();
                            location.reload();
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endsection
