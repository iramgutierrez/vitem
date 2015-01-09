(function () {

  var app = angular.module('sales', [
    'ui.date',
    'sales.controllers',
    'sales.services',
    'users.services',
    'clients.services',
    'products.services',
    'packages.services',
    'destinations.services',
    'users.filters',
    'commissions.filters',
    'destinations.filters',
    'directives',
  ]);

})();
