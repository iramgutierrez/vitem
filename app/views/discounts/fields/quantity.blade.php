<div class="col-sm-12">

    {{ Field::text

        (

            'quantity',

            null ,

            [

                'ng-model' => 'quantity',

                'ng-change' => 'getDiscountPrice()',

                'addon-first' => '<span ng-if="discountType == \'quantity\'">$</span><span  ng-if="discountType == \'percent\'">%</span>',

                'ng-init' => 'quantity = checkValuePreOrOld("'.((!empty($discount->quantity)) ? $discount->quantity : '').'" , "'.((Input::old('quantity')) ? Input::old('quantity') : '').'")',

            ]

        )

    }}

</div>