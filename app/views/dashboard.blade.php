@extends('layout')

@section('header')

    @include('header', [ 'css' => [
                                  'library/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css' ,
                                  'library/css/owl.carousel.css'
                                  ]
                       ]
            )

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')
              <div ng-app="dashboard" >
              <!--state overview start-->
              <div class="row state-overview" ng-controller="CountsController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
                  
                  <div class="col-lg-4 col-sm-12" ng-show="$root.auth_permissions.read.client" >
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-user"></i>
                          </div>
                          <div class="value">
                              <h1 class="count">
                                  0
                              </h1>
                              <p>Nuevos clientes<br>en los ultimos 7 días</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-4 col-sm-12" ng-show="$root.auth_permissions.read.sale" >
                      <section class="panel">
                          <div class="symbol red">
                              <i class="fa fa-tags"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count2">
                                  0
                              </h1>
                              <p>Ventas<br>en el día</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-4 col-sm-12"  ng-show="$root.auth_permissions.read.setting && $root.auth_permissions.read.store"> 
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-dollar"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count4">
                                  0
                              </h1>
                              <p>Saldo actual</p>
                          </div>
                      </section>
                  </div>
              </div>
              <!--state overview end-->

              <div class="row" >
                  @include('graphs/bars') 
              </div>
              <div class="row">                  
                  <div class="col-lg-6">

                      @include('graphs/top_sellers') 

                  </div>
                  <div class="col-lg-6">
                  
                      @include('graphs/last_expenses')

                  </div>
              </div>
              {{--<div class="row">
                  <div class="col-lg-7">

                      @include('graphs/timeline')
                      <!--timeline end-->
                  </div>

              </div>--}}
              
              <div class="row">
                  <div class="col-sm-12">

                      @include('graphs/finished_products_coming') 

                  </div>
              </div>

              <div class="row">

                  <div clas="col-sm-12 col-md-12">

                      @include('graphs/upcoming_deliveries') 
                      
                  </div>
              </div>

              <?php /* <div class="row">
                  <div class="col-lg-8">
                      <!--latest product info start-->
                      <section class="panel post-wrap pro-box">
                          <aside>
                              <div class="post-info">
                                  <span class="arrow-pro right"></span>
                                  <div class="panel-body">
                                      <h1><strong>popular</strong> <br> Brand of this week</h1>
                                      <div class="desk yellow">
                                          <h3>Dimond Ring</h3>
                                          <p>Lorem ipsum dolor set amet lorem ipsum dolor set amet ipsum dolor set amet</p>
                                      </div>
                                      <div class="post-btn">
                                          <a href="javascript:;">
                                              <i class="fa fa-chevron-circle-left"></i>
                                          </a>
                                          <a href="javascript:;">
                                              <i class="fa fa-chevron-circle-right"></i>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          </aside>
                          <aside class="post-highlight yellow v-align">
                              <div class="panel-body text-center">
                                  <div class="pro-thumb">
                                      <img src="{{ asset('library/img/ring.jpg') }}" alt="">
                                  </div>
                              </div>
                          </aside>
                      </section>
                      <!--latest product info end-->
                      <!--twitter feedback start-->
                      <section class="panel post-wrap pro-box">
                          <aside class="post-highlight terques v-align">
                              <div class="panel-body">
                                  <h2>Flatlab is new model of admin dashboard <a href="javascript:;"> http://demo.com/</a> 4 days ago  by jonathan smith</h2>
                              </div>
                          </aside>
                          <aside>
                              <div class="post-info">
                                  <span class="arrow-pro left"></span>
                                  <div class="panel-body">
                                      <div class="text-center twite">
                                          <h1>Twitter Feed</h1>
                                      </div>

                                      <footer class="social-footer">
                                          <ul>
                                              <li>
                                                  <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                  </a>
                                              </li>
                                              <li class="active">
                                                  <a href="#">
                                                      <i class="fa fa-twitter"></i>
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#">
                                                      <i class="fa fa-google-plus"></i>
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#">
                                                      <i class="fa fa-pinterest"></i>
                                                  </a>
                                              </li>
                                          </ul>
                                      </footer>
                                  </div>
                              </div>
                          </aside>
                      </section>
                      <!--twitter feedback end-->
                  </div>
                  <div class="col-lg-4">
                      <div class="row">
                          <div class="col-xs-6">
                              <!--pie chart start-->
                              <section class="panel">
                                  <div class="panel-body">
                                      <div class="chart">
                                          <div id="pie-chart" ></div>
                                      </div>
                                  </div>
                                  <footer class="pie-foot">
                                      Free: 260GB
                                  </footer>
                              </section>
                              <!--pie chart start-->
                          </div>
                          <div class="col-xs-6">
                              <!--follower start-->
                              <section class="panel">
                                  <div class="follower">
                                      <div class="panel-body">
                                          <h4>Jonathan Smith</h4>
                                          <div class="follow-ava">
                                              <img src="{{ asset('library/img/follower-avatar.jpg') }}" alt="">
                                          </div>
                                      </div>
                                  </div>

                                  <footer class="follower-foot">
                                      <ul>
                                          <li>
                                              <h5>2789</h5>
                                              <p>Follower</p>
                                          </li>
                                          <li>
                                              <h5>270</h5>
                                              <p>Following</p>
                                          </li>
                                      </ul>
                                  </footer>
                              </section>
                              <!--follower end-->
                          </div>
                      </div>
                      <!--weather statement start-->
                      <section class="panel">
                          <div class="weather-bg">
                              <div class="panel-body">
                                  <div class="row">
                                      <div class="col-xs-6">
                                        <i class="fa fa-cloud"></i>
                                          California
                                      </div>
                                      <div class="col-xs-6">
                                          <div class="degree">
                                              24°
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <footer class="weather-category">
                              <ul>
                                  <li class="active">
                                      <h5>humidity</h5>
                                      56%
                                  </li>
                                  <li>
                                      <h5>precip</h5>
                                      1.50 in
                                  </li>
                                  <li>
                                      <h5>winds</h5>
                                      10 mph
                                  </li>
                              </ul>
                          </footer>

                      </section>
                      <!--weather statement end-->
                  </div>
              </div> */  ?>

              </div>
      <!--main content end-->

@stop

@section('sidebar_right')

    @include('sidebar_right')

@stop

@section('footer')



    @include('footer', ['js'=> [
                              'library/js/ng/dashboard.js',
                              'library/js/ng/dashboard.controllers.js',
                              'library/js/ng/dashboard.services.js',
                              'library/js/ng/ng-date.js',
                              'library/js/ng/date.format.js' ,
                              'library/js/jquery-ui-1.9.2.custom.min.js' ,
                              'library/js/jquery.sparkline.js' ,
                              'library/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js' ,
                              'library/js/owl.carousel.js' ,
                              'library/js/jquery.customSelect.min.js' ,
                              'library/js/respond.min.js' ,
                              'library/js/sparkline-chart.js' ,
                              'library/js/easy-pie-chart.js' ,
                              'library/js/count.js',
                              'library/js/dashboard.js'
                              ]
                        ]
            )

@stop