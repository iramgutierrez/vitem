<div class="col-sm-12">

    {{ Field::text

        (

            'address',

            null ,

            [

                'ng-model' => 'address',

                'ng-init' => 'address = checkValuePreOrOld("'.((!empty($store->address)) ? $store->address : '').'" , "'.((Input::old('address')) ? Input::old('address') : '').'")',

            ]

        )

    }}

</div>