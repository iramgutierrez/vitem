(function () {

  var app = angular.module('roles', [
    'roles.controllers',
    'roles.services',
    'users.filters',
    'users.directives',
    'frapontillo.bootstrap-switch'
  ])
  .config(function($interpolateProvider) {
        $interpolateProvider.startSymbol('**');
        $interpolateProvider.endSymbol('**');
   });

})();
