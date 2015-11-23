<div class="col-sm-12">

    {{ Field::select

        (

            'type',
            $types,

            '' ,

            [

                'ng-model' => 'type',

                'ng-init' => 'type = checkValuePreOrOld("'.((!empty($discount->type)) ? $discount->type : '').'" , "'.((Input::old('type')) ? Input::old('type') : '').'")'

            ]

        )

    }}

</div>