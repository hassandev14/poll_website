<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamically set title or use a default title -->
    <title>@yield('title', 'My Website')</title> <!-- If no title is specified, "My Website" will be used -->

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
     <!-- DataTables -->
     <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
     <link href="assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />


    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    

   
   
</head>

<body class="fixed-left">

    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center">
                    <a href="{{ url('/') }}" class="logo">
                        <span class="logo-text"><span style="color: #3498db;">AcademiaX</span></span>
                        <i class="ion-ios-rocket-outline logo-icon"></i>
                    </a>
                </div>
            </div>
            
            <!-- Top Bar Navigation -->
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <ul class="nav navbar-right float-right list-inline ml-auto">  <!-- Added ml-auto here -->
                        <!-- User dropdown and notifications -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-img" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0)" class="dropdown-item">Profile</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-item">Settings</a></li>
                                <li><a href="logout" class="dropdown-item">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Top Bar End -->
    </div>
    

        <!-- Sidebar Start -->
        @include('sidebar') <!-- Assuming you have a sidebar.blade.php -->

        <!-- Page Content -->
        <div class="content-page">
