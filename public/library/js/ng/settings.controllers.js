(function () {

  angular.module('settings.controllers', [])

    .controller('FormController', [ '$scope' , '$log' , function ($scope, $log) {

    $scope.switchValue = function(variable)
    { 

    	if(variable == '1')
    	{
    		variable = true;
    	}
    	else
    	{
    		variable = false;
    	}

    	return variable;

    }
    
  }])

})();
