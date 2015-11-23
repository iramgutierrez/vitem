<div class="col-sm-12">

    {{ Field::select

        (

            'discount_type',
            [
                'percent' => 'Porcentaje',
                'quantity' => 'Cantidad fija'
            ],

            '' ,

            [

                'ng-model' => 'discountType',

                'ng-change' => 'getDiscountPrice()',

                'ng-init' => 'discountType = checkValuePreOrOld("'.((!empty($discount->discount_type)) ? $discount->discount_type : '').'" , "'.((Input::old('discount_type')) ? Input::old('discount_type') : '').'")'

            ]

        )

    }}

</div>