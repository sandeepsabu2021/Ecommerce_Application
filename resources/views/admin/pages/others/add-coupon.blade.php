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
                <h1>Add Coupon</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Add Coupon</li>
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
                    <form method="post" action="{{url('/couponvalid')}}">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="code" class="col-sm-2 col-form-label">Code:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Code">
                                    @if($errors->has('code'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('code')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Type:</label>
                                <div class="col-sm-10">
                                    <select name="type" class="form-control">
                                        <option value="">Select Category</option>
                                        <option value="1">Percentage</option>
                                        <option value="2">Flat Off</option>
                                    </select>
                                    @if($errors->has('type'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('type')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quant" class="col-sm-2 col-form-label">Quantity:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="quant" name="quant" placeholder="Quantity">
                                    @if($errors->has('quant'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('quant')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amt" class="col-sm-2 col-form-label">Amount:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="amt" name="amt" placeholder="Amount">
                                    @if($errors->has('amt'))
                                    <div class="alert-danger">
                                        <span class="text-white pl-3">{{$errors->first('amt')}}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>


                            <input type="submit" class="btn btn-primary btn-large" name="addcoupon" value="Add Coupon">

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