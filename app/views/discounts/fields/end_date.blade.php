<div class="col-sm-12">

    {{ Field::date

        (

            'end_date',

            null ,

            [

                'ng-model' => 'endDate',

                'ng-init' => 'endDate = checkValuePreOrOld("'.((!empty($discount->end_date)) ? date( 'm/d/Y' , strtotime($discount->end_date)) : '').'" , "'.((Input::old('end_date')) ? date( 'm/d/Y' , strtotime(Input::old('end_date'))) : '').'")',

                'format-date'

            ]

        )

    }}

</div>