<div class="col-sm-12">

    {{ Field::date

        (

            'date',

            null ,

            [

                'ng-model' => 'date',

                'ng-init' => 'date = checkValuePreOrOld("'.((!empty($commission->date)) ? date( 'm/d/Y' , strtotime($commission->date)) : '').'" , "'.((Input::old('date')) ? date( 'm/d/Y' , strtotime(Input::old('date'))) : '').'" , "'.date( 'm/d/Y').'" , true)',

                'format-date'

            ]

        )

    }}

    <p class="error_message" ng-if="error_date" >@{{ error_date }}</p>

</div>