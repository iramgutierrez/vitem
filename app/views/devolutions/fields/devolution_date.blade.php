<div class="col-sm-12">

    {{ Field::date

        (

            'devolution_date',

            null ,

            [

                'ng-model' => 'devolutionDate',

                'ng-init' => 'devolutionDate = checkValuePreOrOld("'.((!empty($devolution->devolution_date)) ? date( 'm/d/Y' , strtotime($devolution->devolution_date)) : '').'" , "'.((Input::old('devolution_date')) ? date( 'm/d/Y' , strtotime(Input::old('devolution_date'))) : '').'")',

                'format-date'

            ]

        )

    }}

</div>