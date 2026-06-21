<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SPD | Admin Panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/playstore.png') }}">
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('theme') }}/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="{{ asset('theme') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('theme') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet"
        href="{{ asset('theme') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('theme') }}/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">



    <!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    

        @include('css')
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('default') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>SP&</b>D</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>STAR</b>PRO</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        @php
                            $admin = \App\Admin::findorFail(Session::get('id'));
                        @endphp
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('/storage/images/profil/' . $admin->profile_image) }}"
                                    class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Session::get('name') }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">

                                    <img src="{{ asset('/storage/images/profil/' . $admin->profile_image) }}"
                                        class="img-circle" alt="User Image">

                                    <p>
                                        {{ Session::get('name') }} - @if (Session::get('level') == 1)
                                            Super Admin
                                        @else
                                            Admin
                                        @endif
                                        <small>{{ Session::get('email') }}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset('/storage/images/profil/' . $admin->profile_image) }}"
                            class="img-circle img-responsive" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ session('name') }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i>
                            @if (session('level') == 1)
                                Super Admin
                            @else
                                Admin
                            @endif
                        </a>
                    </div>
                </div>
                <div style="margin-top:20px;"></div>

                @include('sidemenu');

            </section>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="">Star Pro Domination (SPD)</a>.</strong> All
            rights
            reserved.
        </footer>
        <div id="loadingProgress" style="display:none;">
            <img src="{{ asset('images') }}/ajax-loader.gif" class="ajax-loader">
        </div>


    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('theme') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('theme') }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('theme') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    @if ($view == 'dashboard')
        <!-- Morris.js charts -->
        <script src="{{ asset('theme') }}/bower_components/raphael/raphael.min.js"></script>
        <!-- <script src="{{ asset('theme') }}/bower_components/morris.js/morris.min.js"></script> -->
        <!-- Sparkline -->
        <script src="{{ asset('theme') }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="{{ asset('theme') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="{{ asset('theme') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('theme') }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('theme') }}/bower_components/moment/min/moment.min.js"></script>
        <script src="{{ asset('theme') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="{{ asset('theme') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset('theme') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    @endif

    @if (
        $view == 'ref' ||
            $view == 'school' ||
            $view == 'laporan-tryout' ||
            $view == 'pengumuman' ||
            $view == 'contact' ||
            $view == 'main-menu' ||
            $view == 'lapor' ||
            $view == 'question' ||
            $view == 'banksoal-exam' ||
            $view == 'banksoal-session' ||
            $view == 'detail-bank-soal' ||
            $view == 'banksoal' ||
            $view == 'exquiz' ||
            $view == 'quiz-header' ||
            $view == 'quiz' ||
            $view == 'slider' ||
            $view == 'admin' ||
            $view == 'information' ||
            $view == 'promo' ||
            $view == 'news' ||
            $view == 'kelas' ||
            $view == 'mapel' ||
            $view == 'kategori' ||
            $view == 'siswa' ||
            $view == 'bimbingan' ||
            $view == 'tryout' ||
            $view == 'detail' ||
            $view == 'materi' ||
            $view == 'tryout-session' ||
            $view == 'exam' ||
            $view == 'tka' ||
            $view == 'tka-detail' ||
            $view == 'tkp' ||
            $view == 'tkp-detail')
        <!-- DataTables -->
        <script src="{{ asset('theme') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('theme') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    @endif



    <!-- Slimscroll -->
    <script src="{{ asset('theme') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{{ asset('theme') }}/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('theme') }}/dist/js/adminlte.min.js"></script>
    <script src="{{ asset('theme') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('theme') }}/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js">
    </script>
    @if ($view == 'dashboard')
        <!-- <script src="{{ asset('theme') }}/dist/js/pages/dashboard.js"></script> -->
    @endif
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('theme') }}/dist/js/demo.js"></script>

    <script src="{{ asset('theme') }}/plugins/ckeditor/ckeditor.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/mathlive"></script>

    <script>
        window.MathJax = {
            tex: {
                inlineMath: [
                    ['\\(', '\\)']
                ],
                displayMath: [
                    ['\\[', '\\]']
                ]
            }
        };

        CKEDITOR.config.versionCheck = false;
    </script>

    <script async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>


    @if ($view == 'laporan-tryout')
        @include('scripts.laporan_tryout_js')
    @endif

    @if ($view == 'profile')
        @include('scripts.profile_js')
    @endif

    @if ($view == 'setting')
       @include('scripts.setting_js')
    @endif

    @if ($view == 'pengumuman')
        @include('scripts.pengumuman_js')
    @endif

    @if ($view == 'lapor')
       @include('scripts.lapor_js')
    @endif

    @if ($view == 'question')
      @include('scripts.question_js')
    @endif


    @if ($view == 'banksoal-exam')
       @include('scripts.bank_soal_exam_js')
    @endif



    @if ($view == 'banksoal-session')
        @include('scripts.bank_soal_session_js')
    @endif

    @if ($view == 'detail-bank-soal')
        @include('scripts.detail_bank_soal_js')
    @endif


    @if ($view == 'banksoal')
       @include('scripts.bank_soal_js')
    @endif

    @if ($view == 'exquiz')
        @include('scripts.exquiz_js')
    @endif

    @if ($view == 'quiz-header')
        @include('scripts.quiz_header_js')
    @endif

    @if ($view == 'quiz')
       @include('scripts.quiz_js')
    @endif

    @if ($view == 'admin')
        @include('scripts.admin_js')
    @endif

    @if ($view == 'siswa')
        @include('scripts.siswa_js')
    @endif

    @if ($view == 'exam')
        @include('scripts.exam_js')
    @endif


    @if ($view == 'tryout-session')
        @include('scripts.tryout_session_js')
    @endif


    @if ($view == 'materi')
       @include('scripts.materi_js')
    @endif

    @if ($view == 'detail')
       @include('scripts.detail_js')
    @endif

    @if ($view == 'tkp')
       @include('scripts.tkp_js')
    @endif

    @if ($view == 'tkp-detail')
        @include('scripts.tkp_detail_js')
    @endif


    @if ($view == 'tryout')
       @include('scripts.tryout_js')
    @endif


    @if ($view == 'bimbingan')
        @include('scripts.bimbingan_js')
    @endif

    @if ($view == 'kategori')
       @include('scripts.kategori_js')
    @endif


    @if ($view == 'mapel')
        @include('scripts.mapel_js')
    @endif

    @if ($view == 'kelas')
       @include('scripts.kelas_js')
    @endif

    @if ($view == 'news')
        @include('scripts.news_js')
    @endif

    @if ($view == 'promo')
       @include('scripts.promo_js')
    @endif

    @if ($view == 'information')
        @include('scripts.information_js')
    @endif

    @if ($view == 'ref')
        @include('scripts.ref_js')
    @endif

    @if ($view == 'slider')
        @include('scripts.slider_js')
    @endif

    @if ($view == 'main-menu')
        @include('scripts.main_menu_js')
    @endif

    @if ($view == 'contact')
        @include('scripts.contact_js')
    @endif


    @if ($view == 'school')
        @include('scripts.school_js')
    @endif

    @if($view == 'tka')
        @include('scripts.tka_js')
    @endif

    @if($view == 'tka-detail' || $view == 'create-tka-page')
        @include('scripts.tka_detail_js')
    @endif

    <style>
        .ML__virtual-keyboard-toggle {
            display: none !important;
        }
    </style>
</body>

</html>
