function getPermissions () {

  this.get = function (role_id)
  {

    var url = 'API/permissions/';

    url += 'getByRoleId' + '?';

    url += 'role_id=' + role_id;

    var auth_permissions = [];

    $.get(url , function (permissions) 
    {
      $.each(permissions , function(key , permission) 
      {
        var action = permission.action.slug;

        var entity = permission.entity.slug;

        if(!auth_permissions.hasOwnProperty(action))
        {

          auth_permissions[action] = [];

        }

        auth_permissions[action][entity] = true;

      });

      var elements = $("ul#nav-accordion *[data-permissions]");

      elements.hide();

      $.each(elements , function (key , element) 
      {
        var el = $(element);

        var entities = el.attr('data-entities').split(',');

        var actions = el.attr('data-actions').split(',');

        $.each(actions , function (key_a , action) 
        {
          $.each(entities , function (key_b , entity) 
          {
            if(auth_permissions.hasOwnProperty(action))
            {
              if(auth_permissions[action].hasOwnProperty(entity))
              {
                el.show();
              }
            }          
          })
        })        
      })
    })
  }
}


