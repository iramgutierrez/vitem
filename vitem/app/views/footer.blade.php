<!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
               2013 &copy; FlatLab by VectorLab.
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

   

    <!-- js placed at the end of the document so the pages load faster -->

    <script src="{{ asset('library/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular.min.js" ></script>
    <script type="text/javascript" src="https://code.angularjs.org/1.2.28/i18n/angular-locale_es-mx.js" ></script>
    
    
    
    <script src="{{ asset('library/js/bootstrap.min.js') }}"></script>
    <script class="include" type="text/javascript" src="{{ asset('library/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('library/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('library/js/jquery.nicescroll.js') }}" type="text/javascript"></script>

    <!--right slidebar-->
    <script src="{{ asset('library/js/slidebars.min.js') }}"></script>

    <!--common script for all pages-->
    <script src="{{ asset('library/js/common-scripts.js') }}"></script>
    @if( isset($js) )
      @foreach ($js as $ks => $script) 
        <script src="{{ asset( $script ) }}"></script>
      @endforeach
      @endif

  </body>
</html>
