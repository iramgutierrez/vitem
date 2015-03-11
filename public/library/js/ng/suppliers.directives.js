(function () {

  angular.module('suppliers.directives', [])

    .directive('suppliersPagination', function () {
      return {
        restrict: 'E',
        templateUrl: 'directives/suppliers-pagination.html'
      };
    })


})();
