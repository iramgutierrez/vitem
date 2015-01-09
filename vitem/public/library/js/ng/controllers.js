(function () {

  angular.module('usersCreate.controllers', [])

    .controller('FormController', function () {

      this.status = true;

      this.changeStatus = function () {

        this.status = !this.status;
        
      };
    });

})();
