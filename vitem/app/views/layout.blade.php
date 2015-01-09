
      @yield('header')  

      @yield('sidebar_left') 

      	<!--main content start-->
        <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
                
                                      
                      	@if(Session::has('success'))
	                      	<div class="alert alert-success fade in">
	                        	<button data-dismiss="alert" class="close close-sm" type="button">
	                            	<i class="fa fa-times"></i>
	                            </button>
	                           	{{ Session::get('success') }}
	                        </div>
                       	@endif

                       	@if(Session::has('error'))
                       	<div class="alert alert-block alert-danger fade in">
                        	<button data-dismiss="alert" class="close close-sm" type="button">
                            	<i class="fa fa-times"></i>
                            </button>
                            {{ Session::get('error') }}
                        </div>
                       	@endif

      					@yield('content')  
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->   

      {{-- @yield('sidebar_right') --}}

      @yield('footer')  




      