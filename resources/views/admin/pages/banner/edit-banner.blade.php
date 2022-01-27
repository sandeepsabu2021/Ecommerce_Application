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
                <h1>Edit Banner</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Edit Banner</li>
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
                    <form method="post" action="{{url('/editbannervalid')}}" enctype="multipart/form-data">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$bannerData->title}}">
                                    @if($errors->has('title'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('title')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subtitle" class="col-sm-2 col-form-label">Sub-Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Sub-Title" value="{{$bannerData->sub_title}}">
                                    @if($errors->has('subtitle'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('subtitle')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="body" class="col-sm-2 col-form-label">Body:</label>
                                <div class="col-sm-10">
                                    <textarea id="body" name="body" class="form-control" placeholder="Body">{{$bannerData->body}}</textarea>
                                    @if($errors->has('body'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('body')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-sm-2 col-form-label">Image:</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="inputGroupFile01">Change image</label>
                                    </div>
                                    @if($errors->has('image'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('image')}}</span>
                                    </div>
                                    @endif
                                    <div>
                                        <img src="{{asset('/uploads/banners/'.$bannerData->image)}}" class="my-2" id="preview-img-tag" alt="Preview" height="200px" width="200px" />
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="img_name" id="img_name" value="{{$bannerData->image}}">
                            <input type="hidden" name="bid" id="bid" value="{{$bannerData->id}}">
                            <input type="submit" class="btn btn-primary btn-large" name="editBanner" value="Update Banner">

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
<script type="text/javascript">
    $(document).ready(function(e) {

        $('#image').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

    });
</script>

@stop
<!-- yield section end -->