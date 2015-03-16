(function () {

 if($("#storesList").length)
 {

    $.get('API/stores' ,function (stores) {

      $.each(stores , function (k , store) {

        $("#storesList").append('<li><a href="change_store/'+store.id+'">'+store.name+'</a></li>');

      })

      console.log(stores);

    })

 }

})();
