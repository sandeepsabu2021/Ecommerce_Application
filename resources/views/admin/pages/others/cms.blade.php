@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delcms").click(function() {
            var id = $(this).attr('cid')
            if (confirm('Delete CMS, are you sure?')) {
                $.ajax({
                    url: "{{url('deletecms')}}",
                    method: 'delete',
                    data: {
                        _token: '{{csrf_token()}}',
                        id: id
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
<script>
    setTimeout(function() {
        $('.alert-div').fadeOut('fast');
    }, 3000); // <-- time in milliseconds
</script>

<div class="container">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>CMS Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">CMS Management</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">CMS Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center">
                                            <a href="add-cms" class="btn btn-primary btn-large text-white">Add New CMS</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-3 text-center">Title</th>
                                        <th class="col-4 text-center">Body</th>
                                        <th class="col-2 text-center">Url</th>
                                        <th class="col-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($cmsData as $cms)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center">{{ $cms->title }}</td>
                                        <td class="text-center">{{ $cms->body }}</td>
                                        <td class="text-center">{{ $cms->url }}</td>
                                        <td class="text-center">
                                            <a href="edit-cms-{{ $cms->id }}" class="btn btn-warning">Edit</a>
                                            <a href="javascript:void(0)" cid="{{ $cms->id }}" class="btn btn-danger text-white delcms">Delete</a>
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
                            {{ $cmsData->links('pagination::bootstrap-4') }}
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