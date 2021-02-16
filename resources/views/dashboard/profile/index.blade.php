@extends('layouts.app')
@section('page_title')Profile settings @endsection
@section('content')
    <div class="container p-5">

        <h1 class="h3 mb-3">Settings</h1>

        <div class="row">
            <div class="col-md-5 col-xl-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account"
                           role="tab">
                            Account
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#password"
                           role="tab">
                            Password
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-xl-8">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account" role="tabpanel">


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Private info</h5>
                            </div>
                            <div class="card-body">
                                <form enctype="multipart/form-data" action="{{route('settings.updateProfile')}}"
                                      method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-row">
                                        <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="inputFirstName">First name</label>
                                            <input value="{{Auth::user()->name}}" type="text" class="form-control"
                                                   id="name" name="name" placeholder="First name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputLastName">Last name</label>
                                            <input value="{{Auth::user()->surname}}" type="text" class="form-control"
                                                   id="surname" name="surname" placeholder="Last name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail4">Email</label>
                                        <input value="{{Auth::user()->email}}" type="email" class="form-control"
                                               id="email" name="email" placeholder="Email">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Password</h5>

                                <form enctype="multipart/form-data" action="{{route('settings.changePassword')}}"
                                      method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
                                        <label for="inputPasswordCurrent">Current password</label>
                                        <input id="old_password" type="password" class="form-control"
                                               name="old_password" required>
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="inputPasswordNew">New password</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNew2">Verify password</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            if (location.hash) {
                $('a[href=' + location.hash + ']').tab('show');
            }
            $(document.body).on("click", "a[data-toggle]", function (event) {
                location.hash = this.getAttribute("href");
            });


            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });


        });
    </script>
@endsection
