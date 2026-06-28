<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Sistem Informasi SPPG Lengkong</title>

    <!-- Google Fonts: Plus Jakarta Sans & Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AdminLTE 3 CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <!-- DataTables CSS Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Premium & Responsive Styles -->
    <style>
        :root {
            --primary-blue: #2c7c8f;
            --primary-blue-hover: #1f5866;
            --pastel-blue: #b5e0ea;
            --light-bg: #f4f6f9;
            --text-dark: #1e293b;
            --border-radius: 12px;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Source Sans Pro', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        /* =====================
           SIDEBAR
        ===================== */
        .main-sidebar {
            background-color: var(--pastel-blue) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        }

        .brand-link {
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
            color: #1e293b !important;
            font-weight: 700 !important;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
        .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: rgba(0, 0, 0, 0.06) !important;
            color: #1e293b !important;
            border-left: 4px solid var(--primary-blue);
        }

        .nav-sidebar .nav-link {
            color: #334155 !important;
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 8px;
            margin-bottom: 2px;
        }

        .nav-sidebar .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.04) !important;
            color: #1e293b !important;
        }

        .nav-header {
            color: #64748b !important;
            font-size: 11px !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px 4px 16px !important;
        }

        /* =====================
           CARDS
        ===================== */
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            border-top-left-radius: var(--border-radius) !important;
            border-top-right-radius: var(--border-radius) !important;
            padding: 16px 20px;
        }

        /* Card header responsif - stack vertikal di mobile */
        .card-header.d-flex {
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-title {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 16px;
        }

        /* =====================
           BUTTONS
        ===================== */
        .btn-success {
            background-color: var(--primary-blue) !important;
            border-color: var(--primary-blue) !important;
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.3s;
            color: #ffffff !important;
        }

        .btn-success:hover {
            background-color: var(--primary-blue-hover) !important;
            border-color: var(--primary-blue-hover) !important;
            transform: translateY(-1px);
        }

        /* =====================
           DATATABLE
        ===================== */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-blue) !important;
            color: white !important;
            border: 1px solid var(--primary-blue) !important;
        }

        /* =====================
           CONTENT WRAPPER
        ===================== */
        .content-wrapper {
            background-color: var(--light-bg) !important;
        }

        .main-header {
            border-bottom: 1px solid #e2e8f0 !important;
        }

        /* =====================
           PAGE TITLE RESPONSIF
        ===================== */
        .content-header h1 {
            font-size: clamp(18px, 4vw, 26px);
        }

        @media (max-width: 576px) {
            .content-header .breadcrumb {
                display: none;
            }
            .content-header .row > div {
                width: 100%;
            }
        }

        /* =====================
           TABEL RESPONSIF
        ===================== */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }

        /* Aksi tombol di tabel - wrap di layar kecil */
        .table td .btn-group,
        .table td .d-flex {
            flex-wrap: wrap;
            gap: 4px;
        }

        @media (max-width: 768px) {
            .table th, .table td {
                white-space: nowrap;
                font-size: 13px;
                padding: 8px 10px;
            }
            .table td .btn-sm {
                padding: 3px 8px;
                font-size: 12px;
            }
        }

        /* =====================
           FORM RESPONSIF
        ===================== */
        @media (max-width: 576px) {
            .form-control, .form-select {
                font-size: 14px;
            }
            .input-group .btn {
                padding: 6px 12px;
            }
            /* Card header dengan search + tombol - stack di mobile */
            .card-header .d-flex.gap-2,
            .card-header .d-flex.flex-wrap {
                width: 100%;
            }
            .card-header .input-group {
                max-width: 100%;
            }
        }

        /* =====================
           NAVBAR RESPONSIF
        ===================== */
        @media (max-width: 576px) {
            .main-header.navbar {
                padding: 0 8px;
            }
        }

        /* =====================
           INFO BOXES (Dashboard)
        ===================== */
        .info-box {
            border-radius: 12px !important;
            overflow: hidden;
        }

        @media (max-width: 576px) {
            .info-box {
                margin-bottom: 12px;
            }
            .info-box-number {
                font-size: 1.4rem !important;
            }
        }

        /* =====================
           MODAL RESPONSIF
        ===================== */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 10px;
            }
            .modal-body {
                padding: 16px;
            }
        }

        /* =====================
           PAGINATION RESPONSIF
        ===================== */
        @media (max-width: 576px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
                gap: 4px;
            }
            .page-link {
                padding: 4px 10px;
                font-size: 13px;
            }
        }

        /* =====================
           UTILITY CLASSES
        ===================== */
        /* Tombol full-width di layar xs */
        @media (max-width: 400px) {
            .btn-xs-full {
                width: 100% !important;
            }
        }

        /* Badge compact di mobile */
        @media (max-width: 576px) {
            .badge {
                font-size: 11px;
                padding: 4px 8px !important;
            }
        }

        /* =====================
           SIDEBAR MINI LAYOUT FIX
        ===================== */
        @media (max-width: 991.98px) {
            .content-wrapper,
            .main-footer {
                margin-left: 0 !important;
            }
        }
    </style>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Sidebar Container -->
    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header py-4">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 fw-bold" style="color: #1e293b; font-size: 26px;">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="#" style="color: var(--primary-blue); text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item active">@yield('page_title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    @include('layouts.partials.footer')
</div>
<!-- ./wrapper -->



<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Global SweetAlert Flash Notifications -->
<script>
    $(document).ready(function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2c7c8f'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#2c7c8f'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#2c7c8f'
            });
        @endif
    });
</script>

<!-- Modal Foto Profil (Global - diletakkan setelah semua JS) -->
@include('layouts.partials.modal_foto_profil')

@yield('scripts')
</body>
</html>
