<div class="col-sm-12">

	{{ Field::text

		(

			'total',

			null ,

			[

				'addon-first' => '$' ,

                'ng-model' => 'subtotal',

                'ng-change' => 'calculateTotal()',

                'ng-init' => "subtotal = checkValuePreOrOld(".((!empty($sale_payment->total)) ? $sale_payment->total : '')." , '".((Input::old('total')) ? Input::old('total') : '') ."')"

			]

		)

	}}

</div>