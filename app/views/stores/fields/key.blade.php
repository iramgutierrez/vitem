<div class="col-sm-12">

    {{ Field::text

        (

            'key',

            null ,

            [

                'ng-model' => 'key',

                'ng-init' => 'key = checkValuePreOrOld("'.((!empty($store->key)) ? $store->key : '').'" , "'.((Input::old('key')) ? Input::old('key') : '').'")',

            ]

        )

    }}

</div>