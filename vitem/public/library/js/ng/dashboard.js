(function () {

  var app = angular.module('dashboard', [
    'ui.date',
    'dashboard.controllers',
    'dashboard.services'
  ]);

  app.filter('capitalize', function() {
    return function(input) {
      return input.charAt(0).toUpperCase() + input.slice(1);
    }
  })

  app.filter('destination_types', function () {

      return function (input) {
        var type;

        if(input == 1)
        {
          type = 'Código postal';

        }else if(input == 2)
        {
          type = 'Colonia';

        }else if(input == 3)
        {
          type = 'Delegación o munucipio';

        }else if(input == 4)
        {
          type = 'Estado';

        }

        return type;

      };
    });

})();
