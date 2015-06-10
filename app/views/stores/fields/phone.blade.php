<div class="col-sm-12">

    {{ Field::text

        (

            'phone',

            null ,

            [

                'ng-model' => 'phone',

                'ng-init' => 'phone = checkValuePreOrOld("'.((!empty($store->phone)) ? $store->phone : '').'" , "'.((Input::old('phone')) ? Input::old('phone') : '').'")',

            ]

        )

    }}

</div>