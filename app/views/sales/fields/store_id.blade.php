
@if(Session::has('current_store.id'))

	<div ng-init="store_id = {{ Session::has('current_store.id') }}" ></div>

@else

	<div class="form-group col-md-6 col-sm-12">
		{{ 

			Field::select(
	    		'store_id', 
	      		$stores,
	      		'' ,
			      [ 
			      	'class' => ' m-bot15  col-md-12' ,

		            'ng-model' => 'store_id',

		            'ng-change' => 'changeStore(); checkAllDiscounts()',

					'ng-init' => 'store_id = checkValuePreOrOld("'.((!empty($sale->store_id)) ? $sale->store_id : '').'" , "'.((Input::old('store_id')) ? Input::old('store_id') : '').'")',


			      ]
	    ) 
    
    }}
  
  </div>   

@endif