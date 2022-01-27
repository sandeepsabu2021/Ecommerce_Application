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
                <h1>Add Configuration</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Add Configuration</li>
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
                    <form method="post" action="{{url('/configvalid')}}">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="email_type" class="col-sm-2 col-form-label">Configuration Type:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email_type" name="email_type" placeholder="Type Name">
                                    @if($errors->has('email_type'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('email_type')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mail" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="mail" name="mail" placeholder="Email">
                                    @if($errors->has('mail'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('mail')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary btn-large" name="addcon" value="Add Config">

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