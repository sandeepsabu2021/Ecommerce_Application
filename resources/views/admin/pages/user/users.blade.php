@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".deluser").click(function() {
            var id = $(this).attr('uid')
            if (confirm('Delete user, are you sure?')) {
                $.ajax({
                    url: "{{url('deleteuser')}}",
                    method: 'delete',
                    data: {
                        _token: '{{csrf_token()}}',
                        uid: id
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
                    <h1>User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">User Management</li>
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
                            <h3 class="card-title">User Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center">
                                            <a href="add-user" class="btn btn-primary btn-large text-white">Add New User</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="col-1 text-center">Sr. No.</th>
                                        <th class="col-2 text-center">Name</th>
                                        <th class="col-3 text-center">Email</th>
                                        <th class="col-2 text-center">Role</th>
                                        <th class="col-2 text-center">Status</th>
                                        <th class="col-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach($userData as $user)
                                    <tr>
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center">{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        @foreach($roleData as $role)
                                        @if($user->role == $role->role_id)
                                        <td class="text-center">{{ $role->role_name }}</td>
                                        @break
                                        @endif
                                        @endforeach
                                        @if($user->status == '1')
                                        <td class="text-center text-success">Active</td>
                                        @else
                                        <td class="text-center text-danger">Inactive</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="modify-user-{{ $user->id }}" class="btn btn-warning">Modify</a>
                                            <a href="javascript:void(0)" uid="{{ $user->id }}" class="btn btn-danger text-white deluser">Delete</a>
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
                            {{ $userData->links('pagination::bootstrap-4') }}
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