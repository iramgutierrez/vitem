<div class="col-sm-12">

    {{ Field::date

        (

            'order_date',

            null ,

            [

                'ng-model' => 'orderDate',

                'ng-init' => 'orderDate = checkValuePreOrOld("'.((!empty($order->order_date)) ? date( 'm/d/Y' , strtotime($order->order_date)) : '').'" , "'.((Input::old('order_date')) ? date( 'm/d/Y' , strtotime(Input::old('order_date'))) : '').'")',

                'format-date'

            ]

        )

    }}

</div>