(function () {

  angular.module('users.directives', [])

    .directive('pagination', function () {
      return {
        restrict: 'E',
        templateUrl: 'directives/pagination.html'
      };
    })

    


})();
