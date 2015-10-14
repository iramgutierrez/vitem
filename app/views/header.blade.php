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

    <title>SIKA Muebles</title>

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
            <a href="{{ route('dashboard') }}" class="logo">Sika<span> muebles</span></a>
            <!--logo end-->

            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->

                </ul>
                <!--  notification end -->
            </div>
            <div class="top-nav ">
                <!--search & user info start-->



                <ul class="nav pull-right top-menu" >

                    <li class="dropdown">

                        <h4>

                            @if( Auth::user()->role->level_id >= 3)

                                @if(Session::has('current_store'))

                                    Sucursal: {{ Session::get('current_store.name') }}

                                @else

                                    Todas las sucursales

                                @endif



                            @else

                                Sucursal: {{ Auth::user()->store->name }}

                            @endif


                        </h4>

                    </li>



                    @if( Auth::user()->role->level_id >= 3)
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span>Cambiar sucursal</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar" id="storesList">
                            <div class="notify-arrow notify-arrow-gray"></div>
                            <li>
                                <a href="{{ route('stores.change') }}">Todas las sucursales</a>
                            </li>
                        </ul>
                    </li>

                    @endif

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