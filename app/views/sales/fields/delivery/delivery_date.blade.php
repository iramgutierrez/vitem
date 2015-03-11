<div class="col-sm-12 col-md-12">

	{{ Field::date

		(

			'delivery.delivery_date', 

			null,

			[ 
                'ng-model' => 'delivery_date ',

				'ng-init' => 'delivery_date = checkValuePreOrOld("'.((!empty($sale->delivery->delivery_date)) ? date( 'm/d/Y' , strtotime($sale->delivery->delivery_date)) : '').'" , "'.((Input::old('delivery.delivery_date')) ? date( 'm/d/Y' , strtotime(Input::old('delivery.delivery_date'))) : '').'")',

                'format-date',

                'placeholder' => ''
            ]

		) 

	}}  

</div>

