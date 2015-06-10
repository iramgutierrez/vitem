<div class="col-sm-12">

    {{ Field::select

        (

            'status',

            $statuses,

            '' ,

            [

                'ng-model' => '$root.status',

                'ng-init' => '$root.status = checkValuePreOrOld("'.((!empty($sale->status)) ? $sale->status : '').'" , "'.((Input::old('status')) ? Input::old('status') : '').'")'

            ]

        )

    }}

</div>