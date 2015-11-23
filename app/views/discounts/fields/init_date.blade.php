<div class="col-sm-12">

    {{ Field::date

        (

            'init_date',

            null ,

            [

                'ng-model' => 'initDate',

                'ng-init' => 'initDate = checkValuePreOrOld("'.((!empty($discount->init_date)) ? date( 'm/d/Y' , strtotime($discount->init_date)) : '').'" , "'.((Input::old('init_date')) ? date( 'm/d/Y' , strtotime(Input::old('init_date'))) : '').'")',

                'format-date'

            ]

        )

    }}

</div>