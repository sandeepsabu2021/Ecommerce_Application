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
<div class="container">

    <!-- Header content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

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
    <!-- /Header content -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order details.</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <section class="text-right my-2 mx-1">
                                <a class="btn btn-dark btn-large" href="downloadcsv">Download Orders CSV</a>
                            </section>

                            <table id="protable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-2 text-center">User</th>
                                        <th class="col-4 text-center">Products</th>
                                        <th class="col-1 text-center">Total</th>
                                        <th class="col-2 text-center">Payment</th>
                                        <th class="col-2 text-center">Order Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($ordData as $ord)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        @foreach($userData as $user)
                                        @if($ord->user_id == $user->id)
                                        <td class="text-center">{{$user->email}}</td>
                                        @endif
                                        @endforeach

                                        <td>
                                            @foreach($proDetails as $pdet)
                                            @if($ord->id == $pdet->order_id)

                                            @foreach($products as $pro)
                                            @if($pdet->product_id == $pro->id)
                                            <p>{{$pro->name}} x {{$pdet->quantity}} at Rs. {{$pdet->price}} = Total Rs. {{$pdet->total}}</p>
                                            @endif
                                            @endforeach

                                            @endif
                                            @endforeach

                                            @foreach($coupon as $c)
                                            @if($c->id == $ord->coupon_id)
                                            <p class="text-info">Coupon : {{$c->code}}</p>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center">Rs. {{ $ord->total }}</td>
                                        @if( $ord->payment_mode == 0)
                                        <td class="text-center">
                                            COD - <span class="text-danger">Pending</span>
                                        </td>
                                        @elseif($ord->payment_mode == 1)
                                        <td class="text-center">
                                            COD - <span class="text-success">Paid</span>
                                        </td>
                                        @else
                                        <td class="text-center text-success">
                                            Paid Online
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            <form method="post" action="{{url('/ordervalid')}}/{{$ord->id}}">
                                                @csrf()
                                                <input type="hidden" name="ordid" value="{{$ord->id}}">
                                                <select name="status" class="form-control">
                                                    <option value="0" <?php if ($ord->status == 0) {
                                                                            echo 'selected';
                                                                        } ?>>Placed</option>
                                                    <option value="1" <?php if ($ord->status == 1) {
                                                                            echo 'selected';
                                                                        } ?>>Confirmed</option>
                                                    <option value="2" <?php if ($ord->status == 2) {
                                                                            echo 'selected';
                                                                        } ?>>Shipped</option>
                                                    <option value="3" <?php if ($ord->status == 3) {
                                                                            echo 'selected';
                                                                        } ?>>Delivered</option>
                                                </select><br />
                                                <input type="submit" class="btn btn-primary" name="ordstatus" value="Change Status">
                                            </form>
                                        </td>

                                    </tr>
                                    @php
                                    $sn++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-foot d-flex justify-content-center">
                            {{ $ordData->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

</div>
<!-- /Main content -->

@stop
<!-- yield section end -->