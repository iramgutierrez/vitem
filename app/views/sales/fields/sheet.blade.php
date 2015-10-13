<div class="col-sm-12">

	{{ Field::text

		(

			'sheet',

			null ,

			[
                'ng-model' => 'sheet' ,

                'ng-value' => 'sheet',

                'ng-init' => 'sheet = checkValuePreOrOld( "'.(!empty($sale->sheet) ? $sale->sheet: '').'" , "'.(Input::old('sheet') ? Input::old('sheet') : '').'" )'
            ]

		)

	}}

</div>