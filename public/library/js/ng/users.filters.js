(function () {

  angular.module('users.filters', [])
    .filter('normalize', function () {
    	var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
      	to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      	mapping = {};
 
  		for(var i = 0, j = from.length; i < j; i++ )
      		mapping[ from.charAt( i ) ] = to.charAt( i );

      	return function( input ) {
		    	var ret = [];
		      	for( var i = 0, j = input.length; i < j; i++ ) {
		        	var c = input.charAt( i );
		          	if( mapping.hasOwnProperty( input.charAt( i ) ) )
		            	ret.push( mapping[ c ] );
		         	else
		            	ret.push( c );
		      	}      
		     return ret.join( '' ).toLowerCase();
		  } 
    })
    .filter('decimal' , function () {
    	return function (input) {
    		if(input == '')
    			return input;
    		var decimal = '';
        	var number  = parseInt(input);
        	if(input.indexOf('.') > 0 ){
        		decimal = input.substring(input.indexOf('.')+1 , ( input.length + 1) )
        		if(decimal)
        			decimal = parseInt(decimal);    
        		decimal = '.' + decimal;
        	}
        	
        	return number +  decimal;
    	}
    })
    .filter('boolean', function () {

      return function (input) {
        var status = (input) ? 'Activo' : 'Inactivo' ;
        return status;

      };
    })
    .filter('range', function() {
      return function(input, total) {
        total = parseInt(total);
        for (var i=0; i<total; i++)
          input.push(i);
        return input;
      };
    });

})();
