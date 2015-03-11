<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <base href="{{ asset('') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{ asset('library/img/favicon.png') }}">

    <title>FlatLab - Flat & Responsive Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('library/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('library/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('library/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />

      <!--right slidebar-->
      <link href="{{ asset('library/css/slidebars.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="{{ asset('library/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('library/css/style-responsive.css') }}" rel="stylesheet" />

    @if( isset($css) )
      @foreach ($css as $kc => $css) 
        <link href="{{ asset( $css ) }}" rel="stylesheet" >
      @endforeach
    @endif



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="{{ route('dashboard') }}" class="logo">Vitem<span> muebles</span></a>
            <!--logo end-->
            
            <?php /* <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <!--<ul class="nav top-menu">-->
                    <!-- settings start -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-success">6</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <!--<li>
                                <p class="green">Generar reporte de ventas por fecha</p>
                            </li>
                            <li>
                                <p class="green">Generar reporte de ventas por vendedor</p>
                            </li>
                            <li>
                                <p class="green">Generar metodo para descargar reporte en xls</p>
                            </li>-->
                            <!--<li>
                                <p class="green">Funcion para sumar o restar al saldo total</p>
                            </li>-->
                            <li>
                                <p class="green">Modulo de pedidos a proveedores</p>
                            </li>
                            <li>
                                <p class="green">Generar modulo de roles y permisos sobre entidades</p>
                            </li>
                            <li>
                                <p class="green">Generar modulo de categorias de gastos</p>
                            </li>
               
                        </ul>
                    </li>
                    <!-- settings end -->
                    <!-- inbox dropdown start-->
                    <!--<li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-important">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-red"></div>
                            <li>
                                <p class="red">You have 5 new messages</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="{{ asset('library/img/avatar-mini.jpg') }}"></span>
                                    <span class="subject">
                                    <span class="from">Jonathan Smith</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is an example msg.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="{{ asset('library/img/avatar-mini2.jpg') }}"></span>
                                    <span class="subject">
                                    <span class="from">Jhon Doe</span>
                                    <span class="time">10 mins</span>
                                    </span>
                                    <span class="message">
                                     Hi, Jhon Doe Bhai how are you ?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="{{ asset('library/img/avatar-mini3.jpg') }}"></span>
                                    <span class="subject">
                                    <span class="from">Jason Stathum</span>
                                    <span class="time">3 hrs</span>
                                    </span>
                                    <span class="message">
                                        This is awesome dashboard.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="{{ asset('library/img/avatar-mini4.jpg') }}"></span>
                                    <span class="subject">
                                    <span class="from">Jondi Rose</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is metrolab
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all messages</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- inbox dropdown end -->
                    <!-- notification dropdown start-->
                    <!--<li id="header_notification_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="fa fa-bell-o"></i>
                            <span class="badge bg-warning">7</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow">You have 7 new notifications</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    Server #3 overloaded.
                                    <span class="small italic">34 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="fa fa-bell"></i></span>
                                    Server #10 not respoding.
                                    <span class="small italic">1 Hours</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    Database overloaded 24%.
                                    <span class="small italic">4 hrs</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success"><i class="fa fa-plus"></i></span>
                                    New user registered.
                                    <span class="small italic">Just now</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-info"><i class="fa fa-bullhorn"></i></span>
                                    Application error.
                                    <span class="small italic">10 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- notification dropdown end -->
                <!--</ul>-->
                <!--  notification end -->
            </div> */ ?>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!--<li>
                        <input type="text" class="form-control search" placeholder="Search">
                    </li>-->
                    <!-- user login dropdown start-->

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="{{ asset('images_profile/'.Auth::user()->image_profile) }}" class="imageProfileHeader">
                            <span class="username">{{ Auth::user()->name }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="{{ route('users.show' , [Auth::user()->id]) }}"><i class=" fa fa-suitcase"></i>Mi perfil</a></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-key"></i> Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <!--<li class="sb-toggle-right">
                        <i class="fa  fa-align-right"></i>
                    </li>-->
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->