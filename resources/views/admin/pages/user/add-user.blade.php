@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->

<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /Header content -->

@if(Session::has('Success'))
<div class="alert alert-success">
    {{Session::get('Success')}}
</div>
@endif
@if(Session::has('Error'))
<div class="alert alert-danger">
    {{Session::get('Error')}}
</div>
@endif

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <!-- form start -->
                    <form method="post" action="{{url('/uservalid')}}">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-2 col-form-label">First Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
                                    @if($errors->has('fname'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('fname')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-sm-2 col-form-label">Last Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                                    @if($errors->has('lname'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('lname')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    @if($errors->has('email'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('email')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role" class="col-sm-2 col-form-label">Role:</label>
                                <div class="col-sm-10">
                                    <select name="role" class="form-control">
                                        @foreach($roleData as $role)
                                        <option value="{{$role->role_id}}" <?php if($role->role_id == '5'){echo 'selected';} ?>> {{$role->role_name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('role'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('role')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Status:</label>
                                <div class="col-sm-10">
                                    <div class="form-control">
                                        <input type="radio" name="status" value="1"><span class="ml-2 mr-3" for="active">Active</span>
                                        <input type="radio" name="status" value="0"><span class="ml-2" for="inactive">Inactive</span>
                                    </div>
                                    @if($errors->has('status'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('status')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    @if($errors->has('password'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('password')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="conpass" class="col-sm-2 col-form-label">Confirm Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="conpass" name="conpass" placeholder="Confirm Password">
                                    @if($errors->has('conpass'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('conpass')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary btn-large" name="addUser" value="Add User">

                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@stop
<!-- yield section end -->