<div class="col-sm-12">

	{{ Field::text

		(

			'subtotal',

			null ,

			[

				'addon-first' => '$' ,

                'ng-model' => 'subtotal',

                'ng-change' => 'calculateTotal()',

                'ng-init' => "subtotal = checkValuePreOrOld(".((!empty($sale_payment->subtotal)) ? $sale_payment->subtotal : '')." , '".((Input::old('subtotal')) ? Input::old('subtotal') : '') ."')"

			]

		)

	}}

</div>