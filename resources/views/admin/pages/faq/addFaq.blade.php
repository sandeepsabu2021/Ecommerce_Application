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
                <h1>Add Faq</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Add Faq</li>
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
                    <form method="post" action="{{url('/faqvalid')}}" enctype="multipart/form-data">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="enter title">
                                </div>
                                    @if($errors->has('title'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('title')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                    
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Description:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="enter description">
                                    
                                        @if($errors->has('description'))
                                        <div class="alert-danger">
                                            <span class="text-white pl-3">{{$errors->first('description')}}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            
                            <input type="submit" class="btn btn-primary btn-large"  value="Add FAQ">

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

@stop
<!-- yield section end -->
