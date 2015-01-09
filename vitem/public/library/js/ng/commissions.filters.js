(function () {

  angular.module('commissions.filters', [])
    .filter('commission_types', function () {

      	return function( input ) {
		    	var ret;

          if(input == 'sale_payments')
          {
            ret = 'Uno o varios abonos';
          }
          else if(input == 'total')
          {
            ret = 'Total de la venta';
          }

          return ret;

		  } 


    })  
})();
