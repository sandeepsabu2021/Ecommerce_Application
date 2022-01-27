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
                <h1>Change Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
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
                <!-- card -->
                <div class="card card-primary">
                    <!-- form start -->
                    <form method="post" action="{{url('/changepassvalid')}}">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="opass" class="col-sm-2 col-form-label">Current Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="opass" name="opass" placeholder="Current Password">
                                    @if($errors->has('opass'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('opass')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pass" class="col-sm-2 col-form-label">New Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="New Password">
                                    @if($errors->has('pass'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('pass')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cpass" class="col-sm-2 col-form-label">Confirm New Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm Password">
                                    @if($errors->has('cpass'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('cpass')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="uid" value="{{ Auth::user()->id }}"> 
                            <input type="submit" class="btn btn-primary btn-large" name="changePass" value="Change Password">
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
<!-- /Main content -->

@stop
<!-- yield section end -->