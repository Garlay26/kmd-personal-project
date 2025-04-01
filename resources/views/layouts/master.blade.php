<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" 
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta content="Active POS System" name="description" />
    <meta content="Active" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/active_fav.png') }}">
    @include('layouts.head-css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .btn-primary {
            background: #02ace0 !important;
            outline: none;
            border: 0;
        }

        .active {
            color: #02ACE0;
        }
    </style>
    {{-- <script type="text/javascript">
        window.onerror = function(message, url, lineNumber) {
            // code to execute on an error
            return true; // prevents browser error messages
        };
    </script> --}}
</head>

@section('body')
    @include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div id="append_alert"></div>
                @if (isset($_REQUEST['status']))
                <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                    <i class="mdi mdi-check-all label-icon"></i><strong>Success</strong> - Your action is success
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                        <i class="mdi mdi-check-all label-icon"></i><strong>Success</strong> -  {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-block-helper me-3 align-middle"></i><strong>Alert</strong> -  {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
</body>

</html>
