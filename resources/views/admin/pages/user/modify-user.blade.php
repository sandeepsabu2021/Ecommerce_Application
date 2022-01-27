@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert-div').fadeOut('fast');
    }, 3000); // <-- time in milliseconds
</script>

<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Modify User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Modify User</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /Header content -->

@if(Session::has('Success'))
<div class="alert alert-success alert-div"> 
    {{Session::get('Success')}}
</div>
@endif
@if(Session::has('Error'))
<div class="alert alert-danger alert-div">
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
                    <form method="post" action="{{url('/modifyuservalid')}}">
                        @csrf()
                        <input type="hidden" name="uid" id="uid" value="{{$userData->id}}">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-2 col-form-label">First Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="{{ $userData->first_name }}">
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
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="{{ $userData->last_name }}">
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
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $userData->email }}">
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
                                        <option value="{{$role->role_id}}" <?php if($role->role_id == $userData->role){echo 'selected';} ?>> {{$role->role_name}}</option>
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
                                        <input type="radio" name="status" value="1" <?php if($userData->status == '1'){echo 'checked';} ?>><span class="ml-2 mr-3" for="active">Active</span>
                                        <input type="radio" name="status" value="0" <?php if($userData->status == '0'){echo 'checked';} ?>><span class="ml-2" for="inactive">Inactive</span>
                                    </div>
                                    @if($errors->has('status'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('status')}}</span>
                                    </div>
                                    @endif
                                </div>
                    
                            </div>

                            <input type="submit" class="btn btn-primary btn-large" name="modifyUser" value="Modify User">

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