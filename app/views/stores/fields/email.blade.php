<div class="col-sm-12">

    {{ Field::text

        (

            'email',

            null ,

            [

                'ng-model' => 'email',

                'ng-init' => 'email = checkValuePreOrOld("'.((!empty($store->email)) ? $store->email : '').'" , "'.((Input::old('email')) ? Input::old('email') : '').'")',

            ]

        )

    }}

</div>