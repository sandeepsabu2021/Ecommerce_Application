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
                <h1>Reply Contact</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Reply Contact</li>
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
                    <form method="post" action="{{url('/replyvalid')}}">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                <div class="col-sm-3">
                                    <input type="text" readonly class="form-control" id="name" name="name" value="{{ $con->name }}" >
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="mail" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-3">
                                    <input type="text" readonly class="form-control" id="mail" name="mail" value="{{ $con->email }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sub" class="col-sm-2 col-form-label">Subject:</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="sub" name="sub" value="{{ $con->subject }}">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="msg" class="col-sm-2 col-form-label">Message:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" readonly rows="3" name="msg" id="msg">{{ $con->message }}</textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="con_reply" class="col-sm-2 col-form-label">Reply:</label>
                                <div class="col-sm-10">
                                   <textarea  class="form-control" required rows="5" name="con_reply"></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="cid" id="cid" value="{{ $con->id }}">
                            <input type="submit" class="btn btn-primary btn-large" name="reply" value="Reply">
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