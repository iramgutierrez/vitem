(function () {

  angular.module('usersCreate.filters', [])

    .filter('boolean', function () {

      return function (input) {
        var status = (input) ? 'Activo' : 'Inactivo' ;
        return status;

      };
    });

})();
