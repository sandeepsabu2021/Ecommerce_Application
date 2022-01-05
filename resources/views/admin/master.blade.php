<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- include head files -->
    @include("admin.includes.head")

    <title>E-commerce Application</title>
</head>

<body>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboard" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User session and Logout -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Welcome: {{ Auth::user()->first_name }}</a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link" href="logout">
                        Logout
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="home" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">App E-comm</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>
                                    Profile
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="change-password" class="nav-link">
                                        <i class="fa fa-key nav-icon"></i>
                                        <p>Change Password</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="edit-profile" class="nav-link">
                                        <i class="far fa-edit nav-icon"></i>
                                        <p>Edit Profile</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="logout" class="nav-link">
                                        <i class="fa fa-sign-out nav-icon"></i>
                                        <p>Logout</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">MANAGEMENT</li>
                        @if( Auth::user()->role == 1 || Auth::user()->role == 2)
                        <li class="nav-item">
                            <a href="user" class="nav-link">
                                <p>
                                    <i class="fa fa-users nav-icon"></i>
                                    User
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="banner" class="nav-link">
                                <p>
                                    <i class="fa fa-image nav-icon"></i>
                                    Banner
                                </p>
                            </a>
                        </li>
                        @endif

                        @if( Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                        <li class="nav-item">
                            <a href="category" class="nav-link">
                                <p>
                                    <i class="fa fa-th-large nav-icon"></i>
                                    Category
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="product" class="nav-link">
                                <p>
                                    <i class="fas fa-square nav-icon"></i>
                                    Product
                                </p>
                            </a>
                        </li>
                        @endif

                        @if( Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 4)
                        <li class="nav-item">
                            <a href="order" class="nav-link">
                                <p>
                                    <i class="fas fa-clipboard-list nav-icon"></i>
                                    Order
                                </p>
                            </a>
                        </li>
                        @endif

                        @if( Auth::user()->role == 1 || Auth::user()->role == 2)
                        <li class="nav-item">
                            <a href="contact" class="nav-link">
                                <p>
                                    <i class="fa fa-envelope nav-icon"></i>
                                    Contact
                                </p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper">
            <main>
                @yield('content')
            </main>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2021. E-commerce Application</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                Developed by <b>Sandeep Sabu</b>
            </div>
        </footer>

    </div>
    @include("admin.includes.foot")
</body>

</html>