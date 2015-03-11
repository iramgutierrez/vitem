(function () {

  angular.module('directives', [])

    .directive('pagination', function () {
      return {
        restrict: 'E',
        templateUrl: 'directives/pagination.html'
      };
    })

    .directive("formatDate", function(){
	  return {
	   require: 'ngModel',
	    link: function(scope, elem, attr, modelCtrl) {
	      modelCtrl.$formatters.push(function(modelValue){
	        return new Date(modelValue);
	      })
	    }
	  }
	})


})();
