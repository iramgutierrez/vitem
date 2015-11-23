<div class="col-sm-12">

    {{ Field::select

        (

            'DiscountStore',
            [],

            '' ,

            [

                'ng-model' => 'stores',

                'multiple' => 'multiple',

                'ng-options' => 's.id as s.name for s in allStores',

                'ng-init' => 'stores = checkValuePreOrOld("'.((!empty($discount->stores)) ? $discount->stores : '').'" , "'.((Input::old('stores')) ? Input::old('stores') : '').'")'

            ]

        )

    }}

    <input type="hidden" name="DiscountStore" ng-model="stores" ng-value="stores"/>

</div>