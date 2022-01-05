@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script>
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
                        alert(response)
                        window.location.reload();
                    }
                })
            }

        })

    })
</script> -->
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
    <div class="alert alert-success">
        {{Session::get('Success')}}
    </div>
    @endif
    @if(Session::has('Error'))
    <div class="alert alert-danger">
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
                                        <th class="col-1 text-center">Payment</th>
                                        <th class="col-1 text-center">Status</th>
                                        <th class="col-2 text-center">Action</th>
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
                                            <p>{{$pro->name}} x {{$pdet->quantity}} at Rs. {{$pdet->price}}</p>
                                            @endif
                                            @endforeach
                                        
                                        @endif
                                        @endforeach
                                        </td>
                                        <td class="text-center">Rs. {{ $ord->total }}</td>
                                        <td class="text-center">Paid</td>
                                        <td class="text-center">{{ $ord->status }}</td>
                                        <td class="text-center">
                                            <a href="view-order-{{ $ord->id }}" class="btn btn-warning">View</a>
                                            <a href="edit-product-{{ $ord->id }}" class="btn btn-info text-white">Change Status</a>
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