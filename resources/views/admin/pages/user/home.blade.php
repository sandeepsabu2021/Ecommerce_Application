@extends('admin.master')
<!-- main layout -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert-div').fadeOut('fast');
    }, 3000); // <-- time in milliseconds
</script>

@section('content')
<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Welcome to E-commerce Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card-header -->
                    <div class="card-header">
                        <h3 class="card-title">Welcome {{ Auth::user()->first_name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- card-body -->
                    @if( Auth::user()->role == 1 || Auth::user()->role == 2)
                    <div class="card-body">
                        <a href="dashboard" class="btn btn-primary btn-large mr-2">Dashboard</a>
                    </div>
                    @endif
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<!-- /Main content -->

@stop
<!-- yield section end -->