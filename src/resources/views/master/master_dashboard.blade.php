<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/fc-5.0.4/fh-4.0.1/r-3.0.3/sc-2.4.3/datatables.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
    @include('master.dashboard.topbar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('master.dashboard.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('main')
            </main>
            @include('master.dashboard.footer')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/js/all.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/fc-5.0.4/fh-4.0.1/r-3.0.3/sc-2.4.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('js')
</body>

</html>
