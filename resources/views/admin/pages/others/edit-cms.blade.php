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
                <h1>Edit CMS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Edit CMS</li>
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
                    <form method="post" action="{{url('/editcmsvalid')}}" enctype="multipart/form-data">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$cmsData->title}}">
                                    @if($errors->has('title'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('title')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="body" class="col-sm-2 col-form-label">Body:</label>
                                <div class="col-sm-10">
                                    <textarea id="body" name="body" class="form-control" placeholder="Body">{{$cmsData->body}}</textarea>
                                    @if($errors->has('body'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('body')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="url" class="col-sm-2 col-form-label">URL:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="url" name="url" placeholder="Page Url" value="{{$cmsData->url}}">
                                    @if($errors->has('url'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('url')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                           
                            <input type="hidden" name="cid" id="cid" value="{{$cmsData->id}}">
                            <input type="submit" class="btn btn-primary btn-large" name="editCMS" value="Update CMS">

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