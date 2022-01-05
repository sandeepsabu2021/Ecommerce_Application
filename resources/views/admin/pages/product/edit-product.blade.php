@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delimg").click(function() {
            var id = $(this).attr('iid')
            if (confirm('Do you want to delete this image?')) {
                $.ajax({
                    url: "{{url('deleteimage')}}",
                    method: 'delete',
                    data: {
                        _token: '{{csrf_token()}}',
                        iid: id
                    },
                    success: function(response) {
                        alert(response)
                        window.location.reload();
                    }
                })
            }

        })

    })
</script>

<!-- Header content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
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
                    <form method="post" action="{{url('/editproductvalid')}}" enctype="multipart/form-data">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" value="{{ $proData->name }}">
                                    @if($errors->has('name'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('name')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="desc" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="desc" id="desc" placeholder="Product Description">{{ $proData->description }}</textarea>
                                    @if($errors->has('desc'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('desc')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="catid" class="col-sm-2 col-form-label">Category:</label>
                                <div class="col-sm-10">
                                    <select name="catid" class="form-control">
                                        @foreach($catData as $cat)
                                        <option value="{{$cat->id}}" <?php if ($proData->category_id == $cat->id) {
                                                                            echo 'selected';
                                                                        } ?>>{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('catid'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('catid')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="price" class="col-sm-2 col-form-label">Price:</label>

                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rs.</span>
                                        </div>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Price" value="{{ $proData->price }}">
                                    </div>
                                    @if($errors->has('price'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('price')}}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="quantity" class="col-sm-2 col-form-label">Quantity:</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" value="{{ $proData->quantity }}">
                                    @if($errors->has('quantity'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('quantity')}}</span>
                                    </div>
                                    @endif
                                </div>

                            </div>

                            <h6 class="mt-4 mb-3 text-center text-secondary">Additional Product Details</h6>

                            <div class="form-group row">

                                <label for="brand" class="col-sm-2 col-form-label">Brand:</label>
                                <div class="col-sm-3">
                                    <input class="form-control" list="brands" name="brand" value="{{ $attData->brand }}" />
                                    <datalist id="brands">
                                    </datalist>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="size" class="col-sm-2 col-form-label">Size:</label>
                                <div class="col-sm-3">
                                    <input class="form-control" list="sizes" name="size" value="{{ $attData->size }}" />
                                    <datalist id="sizes">
                                    </datalist>
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="gender" class="col-sm-2 col-form-label">Gender:</label>
                                <div class="col-sm-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Male" <?php if ($attData->gender == 'Male') {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Female" <?php if ($attData->gender == 'Female') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Unisex" <?php if ($attData->gender == 'Unisex') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                        <label class="form-check-label" for="unisex">Unisex</label>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="color" class="col-sm-2 col-form-label">Color:</label>
                                <div class="col-sm-3">
                                    <input type="color" class="form-control" id="color" name="color" value="{{ $attData->color }}">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="filenames" class="col-sm-2 col-form-label">Images:</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="filenames" name="filenames[]" multiple>
                                        <label class="custom-file-label" for="filenames">Choose images</label>
                                    </div>
                                    @if($errors->has('filenames'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('filenames')}}</span>
                                    </div>
                                    @endif
                                    <div class="row my-2">
                                        @if($images)
                                        @foreach($images as $img)
                                        <div class="col-sm-3 mx-auto">
                                            <img src="{{asset('/uploads/products/'.$img->image)}}" style="height: 200px;" class="img-thumbnail">
                                            <a href="javascript:void(0)" iid="{{ $img->id }}" class="btn btn-danger rounded-circle text-white delimg" style="position:absolute; top:0; right:0;">X</a>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="gallery"></div>
                                </div>
                            </div>

                            <input type="hidden" name="pid" value="{{ $proData->id }}">
                            <input type="submit" class="btn btn-primary btn-large" name="editProduct" value="Update Product">

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
<script>
    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }

        };
        $('#filenames').on('change', function() {
            imagesPreview(this, 'div.gallery');
        });
    });
</script>

@stop
<!-- yield section end -->