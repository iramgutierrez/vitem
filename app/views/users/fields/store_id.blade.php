
@if(Session::has('current_store'))

@else

	<div class="form-group col-md-6 col-sm-12">
		{{ 

			Field::select(
	    	'store_id', 
	      $stores,
	      '' ,
	      [ 
	      	'class' => ' m-bot15  col-md-12' 
	      ]
	    ) 
    
    }}
  
  </div>   

@endif