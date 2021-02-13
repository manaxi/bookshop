@extends('layouts.app')
@section('page_title')Profile settings @endsection
@section('content')
    <div class="container p-5">
        <h1 class="h3 mb-3">Dashboard</h1>
        <a class="btn btn-primary" href="{{route('dashboard.books.create')}}" role="button">Add book</a>

        <h3>Your Books</h3>
        <table class="table table-bordered" id="datatable-crud">
            <thead>
            <tr>
                <th>Id</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Authors</th>
                <th>Genres</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.books.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'cover_image', name: 'cover_image'},
                    {data: 'title', name: 'title'},
                    {data: 'authors', name: 'authors'},
                    {data: 'genres', name: 'genres'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'desc']]
            });
        });
    </script>
@endsection


