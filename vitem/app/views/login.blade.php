<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>FlatLab - Flat & Responsive Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('library/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('library/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('library/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('library/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('library/css/style-responsive.css') }}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">
        @if(Session::has('login_error'))
        <div class="form-signin">
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                Los datos de acceso son incorrectos.
            </div>
        </div>
        @endif


    	{{ Form::open(['route' => 'login', 'class' => 'form-signin' , 'method' => 'POST', 'role' => 'form', 'novalidate']) }}

      <!--<form class="form-signin" action="index.html">-->
        <h2 class="form-signin-heading">Iniciar sesión</h2>
        <div class="login-wrap">
        	{{ Form::text('username' , '', ['class' => 'form-control', 'autofocus' , 'placeholder' => 'Usuario' ]) }}
        	{{ Form::password('password' , ['class' => 'form-control' , 'placeholder' => 'Contraseña' ] ) }}
            <label class="checkbox">
        		{{ Form::checkbox('remember' , 'remember') }}Recordarme
            </label>
            {{ Form::submit('Enviar' , ['class'  => 'btn btn-lg btn-login btn-block' ] ) }}
            <!--<input class="btn btn-lg btn-login btn-block" type="submit" value="Entrar" />-->           
        </div>
      <!--</form>-->
      {{ Form::close() }}

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ asset('library/js/jquery.js') }}"></script>
    <script src="{{ asset('library/js/bootstrap.min.js') }}"></script>


  </body>
</html>