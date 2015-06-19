<div class="col-sm-12">

    {{ Field::select

        (

            'status_pay',

            [
            	'pagado' => 'Pagado',
            	'pendiente' => 'Pendiente',
            ],

            '' ,

            [

                'ng-model' => 'status_pay',

                'ng-init' => 'status_pay = checkValuePreOrOld("'.((!empty($order->status_pay)) ? $order->status_pay : '').'" , "'.((Input::old('status_pay')) ? Input::old('status_pay') : '').'")'

            ]

        )

    }}

</div>