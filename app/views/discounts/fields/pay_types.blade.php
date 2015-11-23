<div class="col-sm-12">
    <?php print_r(Input::old('pay_types'));?>

    {{ Field::select

        (

            'pay_types',
            [],

            '' ,

            [

                'ng-model' => 'payTypes',

                'multiple' => 'multiple',

                'ng-options' => 'p as p.name for p in allPayTypes',

                'ng-init' => 'getPayTypes(checkValuePreOrOld(\''.((!empty($discount->pay_types)) ? json_encode($discount->pay_types) : '').'\' , \''.((Input::old('pay_types')) ? json_encode(Input::old('pay_types')) : '').'\'));'

            ]

        )

    }}


</div>