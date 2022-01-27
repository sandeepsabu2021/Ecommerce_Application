@extends('admin.master')
<!-- main layout -->

@section('content')
<!-- yield section start -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Users', 'Registered Users'],
            <?php
            if ($pieChart) {
                echo $pieChart;
            }
            ?>
        ]);

        var options = {
            title: 'Users'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Products', 'Product sales'],
            <?php
            if ($proChart) {
                echo $proChart;
            }
            ?>
        ]);

        var options = {
            title: 'Products'
        };

        var chart = new google.visualization.PieChart(document.getElementById('prochart'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
            ['Status', 'Users'],
            <?php
            if ($barChart) {
                echo $barChart;
            }
            ?>
        ]);

        var options = {
            width: 500,

            bars: 'horizontal', // Required for Material Bar Charts.
            series: {
                0: {
                    axis: 'distance'
                }, // Bind series 0 to an axis named 'distance'.
                1: {
                    axis: 'brightness'
                } // Bind series 1 to an axis named 'brightness'.
            },
            axes: {
                x: {
                    distance: {
                        label: 'Users'
                    }, // Bottom x-axis.
                    brightness: {
                        side: 'top',
                        label: 'apparent magnitude'
                    } // Top x-axis.
                }
            }
        };

        var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
        chart.draw(data, options);
    };
</script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
            ['Used Coupons', 'Coupons'],
            <?php
            if ($copChart) {
                echo $copChart;
            }
            ?>
        ]);

        var options = {
            width: 500,

            bars: 'vertical', // Required for Material Bar Charts.
            series: {
                0: {
                    axis: 'distance'
                }, // Bind series 0 to an axis named 'distance'.
                1: {
                    axis: 'brightness'
                } // Bind series 1 to an axis named 'brightness'.
            },
            axes: {
                x: {
                    distance: {
                        label: 'Coupons'
                    }, // Bottom x-axis.
                    brightness: {
                        side: 'top',
                        label: 'apparent magnitude'
                    } // Top x-axis.
                }
            }
        };

        var chart = new google.charts.Bar(document.getElementById('coupon'));
        chart.draw(data, options);
    };
</script>

<!-- Header content -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total }}</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $order }}</h3>

                        <p>Orders Placed</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $ptotal }}</h3>

                        <p>Products Sold</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-tshirt"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $cop_count }}</h3>

                        <p>Coupons Used</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->


            <div class="col-lg-6">
                <!-- card -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Users and Roles</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- d-flex -->
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $total }}</span>
                                <span>Registered Users</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div id="piechart" style="width: 100%; height: 300px;"></div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <!-- card -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Active & Inactive Users</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- d-flex -->
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $total }}</span>
                                <span>Total Users</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div id="dual_x_div" style="width: 100px; height: 300px;"></div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->

            <div class="col-lg-6">
                <!-- card -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Coupon Data</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- d-flex -->
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $cop_count }}</span>
                                <span>Coupons Used</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div id="coupon" style="width: 100px; height: 300px;"></div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <!-- card -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Product Sales</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- d-flex -->
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $ptotal }}</span>
                                <span>Products Sold</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div id="prochart" style="width: 100%; height: 300px;"></div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div>
</div>
<!-- /Main content -->

@stop
<!-- yield section end -->