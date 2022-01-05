@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $(".delcat").click(function(){
            var id = $(this).attr('cid')
            if(confirm('Category and all related products will be deleted. Are you sure?')){
                $.ajax({
                    url:"{{url('deletecat')}}",
                    method: 'delete',
                    data: {_token:'{{csrf_token()}}' , cid:id},
                    success:function(response){
                        alert(response)
                        window.location.reload();
                    }
                })
            }
            
        })

    })
</script>

<div class="container">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                            <h3 class="card-title">Categories with name and description.</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="cattable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">
                                            <a href="add-category" class="btn btn-primary btn-large text-white">Add New Category</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-2 text-center">Name</th>
                                        <th class="col-5">Description</th>
                                        <th class="col-2 text-center">Products</th>
                                        <th class="col-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($catData as $cat)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center">{{ $cat->name }}</td>
                                        <td>{{ $cat->description }}</td>
                                        <td class="text-center">
                                            <a href="product{{ $cat->id }}" class="btn btn-warning">View</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit-category-{{ $cat->id }}" class="btn btn-info text-white">Edit</a>
                                            <a href="javascript:void(0)" cid="{{ $cat->id }}" class="btn btn-danger text-white delcat">Delete</a>
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
                            {{ $catData->links('pagination::bootstrap-4') }}
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