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
    <!--<script type="text/javascript" src="{{ asset('library/js/ng/angular.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('library/js/ng/angular-locale_es-mx.js') }}" ></script>-->
    
    
    
    <script src="{{ asset('library/js/bootstrap.min.js') }}"></script>
    <script class="include" type="text/javascript" src="{{ asset('library/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('library/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('library/js/jquery.nicescroll.js') }}" type="text/javascript"></script>

    <!--right slidebar-->
    <script src="{{ asset('library/js/slidebars.min.js') }}"></script>

    <!--common script for all pages-->
    <script src="{{ asset('library/js/common-scripts.js') }}"></script>

    @if( Auth::user()->role->level_id >= 3)
    
      <script src="{{ asset('library/js/ng/header.js' ) }}"></script>

    @endif

    @if( isset($js) )
      @foreach ($js as $ks => $script) 
        <script src="{{ asset( $script ) }}"></script>
      @endforeach
    @endif

    <!-- cdn for modernizr, if you haven't included it already -->
    <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
    <!-- polyfiller file to detect and load polyfills -->
    <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
    <script>
      webshims.setOptions('waitReady', false);
      webshims.setOptions('forms-ext', {types: 'date'});
      webshims.polyfill('forms forms-ext');
    </script>

  </body>
</html>
