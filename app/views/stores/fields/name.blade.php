<div class="col-sm-12">

    {{ Field::text

        (

            'name',

            null ,

            [

                'ng-model' => 'name',

                'ng-init' => 'name = checkValuePreOrOld("'.((!empty($store->name)) ? $store->name : '').'" , "'.((Input::old('name')) ? Input::old('name') : '').'")',

            ]

        )

    }}

</div>