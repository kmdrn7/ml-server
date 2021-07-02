<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &mdash; {{ config('app.name') }} Admin Dashboard</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ backend('vendor/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ backend('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.css">
    <link rel="stylesheet" href="{{ backend('css/vendor-material-icons.css') }}">
    <link rel="stylesheet" href="{{ backend('css/vendor-fontawesome-free.css') }}">
    <link rel="stylesheet" href="{{ backend('css/vendor-flatpickr.css') }}">
    <link rel="stylesheet" href="{{ backend('css/vendor-flatpickr-airbnb.css') }}">
    <link rel="stylesheet" href="{{ backend('css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ backend('skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ backend('vendor/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ backend('css/admin.css?v='.app_version()) }}">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('storage/app_logo.png') }}">

    <!-- Inject CSS -->
    @yield('css')

    <script>
        let LAST_PAGE = '';
        let APP = '{{ $app }}';
        let IDH = '{{ url()->current() }}';
        let COLUMNS = [];
        let SELECT_COLUMNS;
        let PAGE_LENGTH = 10;
        let ID_TABLE;
        let DT;
        let AjaxData = {};
        let btnView, btnUpdate, btnDelete;
        let ADD_MSG;
        let dt_old = {
            paging: null
        }
    </script>
</head>
<body class="layout-default">
    <div class="preloader"></div>
    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">
        @include('admin.layouts.navbar')
        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">
            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
                @yield('content')
                @include('admin.layouts.sidebar')
            </div>
        </div>
        <!-- END Header Layout Content -->
    </div>

    @yield('modal')
    <!-- Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sedang Memproses</h5>
                </div>
                <div class="modal-body">
                    <i class="fa fa-life-ring fa-spin" aria-hidden="true"></i>&nbsp; Sedang memproses permintaan anda...
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ backend('vendor/jquery.min.js') }}"></script>
    <script src="{{ backend('vendor/popper.min.js') }}"></script>
    <script src="{{ backend('vendor/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="{{ backend('vendor/simplebar.min.js') }}"></script>
    <script src="{{ backend('vendor/dom-factory.js') }}"></script>
    <script src="{{ backend('vendor/material-design-kit.js') }}"></script>
    <script src="{{ backend('vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ backend('js/moment.min.js') }}"></script>
    <script src="{{ backend('js/toggle-check-all.js') }}"></script>
    <script src="{{ backend('js/icheck.min.js') }}"></script>
    <script src="{{ backend('js/flatpickr.js') }}"></script>
    <script src="{{ backend('js/flatpickr.id.js') }}"></script>
    <script src="{{ backend('js/check-selected-row.js') }}"></script>
    <script src="{{ backend('js/dropdown.js') }}"></script>
    <script src="{{ backend('js/dropify.min.js') }}"></script>
    <script src="{{ backend('js/sidebar-mini.js') }}"></script>

    <script>
        (function() {
            'use strict';
            // Self Initialize DOM Factory Components
            domFactory.handler.autoInit()
            // Connect button(s) to drawer(s)
            var sidebarToggle = document.querySelectorAll('[data-toggle="sidebar"]')
            sidebarToggle = Array.prototype.slice.call(sidebarToggle)
            sidebarToggle.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    var selector = e.currentTarget.getAttribute('data-target') || '#default-drawer'
                    var drawer = document.querySelector(selector)
                    if (drawer) {
                        drawer.mdkDrawer.toggle()
                    }
                })
            })
            let drawers = document.querySelectorAll('.mdk-drawer')
            drawers = Array.prototype.slice.call(drawers)
            drawers.forEach((drawer) => {
                drawer.addEventListener('mdk-drawer-change', (e) => {
                    if (!e.target.mdkDrawer) {
                        return
                    }
                    document.querySelector('body').classList[e.target.mdkDrawer.opened ? 'add' : 'remove']('has-drawer-opened')
                    let button = document.querySelector('[data-target="#' + e.target.id + '"]')
                    if (button) {
                        button.classList[e.target.mdkDrawer.opened ? 'add' : 'remove']('active')
                    }
                })
            })
            // SIDEBAR COLLAPSE MENUS
            $('.sidebar .collapse').on('show.bs.collapse', function(e) {
                e.stopPropagation()
                var parent = $(this).parents('.sidebar-submenu').get(0) || $(this).parents('.sidebar-menu').get(0)
                $(parent).find('.open').find('.collapse').collapse('hide');
                $(this).closest('li').addClass('open');
            });
            $('.sidebar .collapse').on('hidden.bs.collapse', function(e) {
                e.stopPropagation()
                $(this).closest('li').removeClass('open');
            });
            // ENABLE TOOLTIPS
            $('[data-toggle="tooltip"]').tooltip()
            // PRELOADER
            window.addEventListener('load', function() {
                $('.preloader').fadeOut()
                domFactory.handler.upgradeAll()
            })
        })()
    </script>

    <script>
        (function() {
            'use strict';
            $('[data-toggle="tab"]').on('hide.bs.tab', function(e) {
                $(e.target).removeClass('active')
            })
        })()
    </script>

    <!-- Inject JS -->
    @yield('js')

    <!-- Template JS File -->
    <script src="{{ backend('js/admin.js?v='.app_version()) }}"></script>
</body>
</html>