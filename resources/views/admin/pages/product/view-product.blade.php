@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delpro").click(function() {
            var id = $(this).attr('pid')
            if (confirm('Do you want to delete this product?')) {
                $.ajax({
                    url: "{{url('deleteproduct')}}",
                    method: 'delete',
                    data: {
                        _token: '{{csrf_token()}}',
                        pid: id
                    },
                    success: function(response) {
                        if (response == 'Product deleted successfully') {
                            window.location.href = "{{url('/product')}}";
                        } else {
                            alert(response)
                        }

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
                <h1>Product - {{ $proData->type }}
                </h1>
                <p>Added on - {{ $proData->created_at }}</p>
                @if( $proData->type == 1)
                    <h5 class="text-primary">Featured</h5>
                    @endif
                    @if( $proData->type == 2)
                    <h5 class="text-danger">Recommended</h5>
                    @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /Header content -->


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <!-- form start -->

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" value="{{ $proData->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desc" class="col-sm-2 col-form-label">Description:</label>
                            <div class="col-sm-10">
                                <textarea readonly class="form-control">{{ $proData->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="img" class="col-sm-2 col-form-label">Thumbnail:</label>
                            <div class="col-sm-10">
                                <div>
                                    <img src="{{asset('/uploads/thumbnails/'.$proData->thumbnail)}}" class="my-2 img-thumbnail" id="preview-img-tag" alt="Preview" height="200px" width="200px" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="catid" class="col-sm-2 col-form-label">Category:</label>
                            <div class="col-sm-2">
                                @foreach($catData as $cat)
                                @if($proData->category_id == $cat->id)
                                <input type="text" readonly class="form-control" value="{{ $cat->name }}">
                                @endif
                                @endforeach
                            </div>

                            <label for="price" class="col-sm-2 col-form-label">Price:</label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="number" readonly class="form-control" value="{{ $proData->price }}">
                                </div>
                            </div>

                            <!-- <div class="col-sm-2"></div> -->
                            <label for="quantity" class="col-sm-2 col-form-label">Quantity:</label>
                            <div class="col-sm-2">
                                <input type="number" readonly class="form-control" value="{{ $proData->quantity }}">
                            </div>
                        </div>

                        <div class="form-group row">



                        </div>

                        <h6 class="mt-4 mb-3 text-center text-secondary">Additional Product Details</h6>

                        <div class="form-group row">

                            <label for="brand" class="col-sm-2 col-form-label">Brand:</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" value="{{ $attData->brand }}" />
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="size" class="col-sm-2 col-form-label">Size:</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" value="{{ $attData->size }}" />
                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="gender" class="col-sm-2 col-form-label">Gender:</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" value="{{ $attData->gender }}" />
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="color" class="col-sm-2 col-form-label">Color:</label>
                            <div class="col-sm-3">
                                <div class="form-control" style="background-color: <?php echo $attData->color ?>"></div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="filenames" class="col-sm-2 col-form-label">Images:</label>
                            <div class="col-sm-10">
                                <div class="row my-2">
                                    @if($images)
                                    @foreach($images as $img)
                                    <div class="col-sm-3 mx-auto">
                                        <img src="{{asset('/uploads/products/'.$img->image)}}" style="height: 200px;" class="img-thumbnail">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-right mr-4">
                            <a href="edit-product-{{ $proData->id }}" class="btn btn-info text-white">Edit</a>
                            <a href="javascript:void(0)" pid="{{ $proData->id }}" class="btn btn-danger text-white delpro">Delete</a>
                        </div>

                    </div>

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