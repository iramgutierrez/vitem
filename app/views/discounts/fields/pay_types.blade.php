<div class="col-sm-12">
    <?php print_r(Input::old('pay_types'));?>

    {{ Field::select

        (

            'DiscountPayType',
            [],

            '' ,

            [

                'ng-model' => 'payTypes',

                'multiple' => 'multiple',

                'ng-options' => 'p.id as p.name for p in allPayTypes',

                'ng-init' => 'payTypes = checkValuePreOrOld(\''.((!empty($discount->pay_types)) ? $discount->pay_types : '').'\' , \''.((Input::old('pay_types')) ? Input::old('pay_types') : '').'\')'

            ]

        )

    }}

    <input type="hidden" name="DiscountPayType" ng-model="payTypes" ng-value="payTypes"/>

</div>