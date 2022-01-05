@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="container">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Contact Management</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contact Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>

                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-2 text-center">Name</th>
                                        <th class="col-2 text-center">Email</th>
                                        <th class="col-2 text-center">Subject</th>
                                        <th class="col-3 text-center">Message</th>
                                        <th class="col-1 text-center">Status</th>
                                        <th class="col-1 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($conData as $con)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center">{{ $con->name }}</td>
                                        <td class="text-center">{{ $con->email }}</td>
                                        <td class="text-center">{{ $con->subject }}</td>
                                        <td class="text-center">{{ $con->message }}</td>
                                        <td class="text-center">{{ $con->status }}</td>
                                        <td class="text-center">
                                            <a href="reply-contact-{{ $con->id }}" class="btn btn-warning">Reply</a>
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
                            {{ $conData->links('pagination::bootstrap-4') }}
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