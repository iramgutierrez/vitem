(function () {

  angular.module('clients.directives', [])

    .directive('clientsPagination', function () {
      return {
        restrict: 'E',
        templateUrl: 'directives/clients-pagination.html'
      };
    })


})();
