<div class="col-sm-12">

    {{ Field::select

        (

            'stores',
            [],

            '' ,

            [

                'ng-model' => 'stores',

                'multiple' => 'multiple',

                'ng-options' => 's.id as s.name for s in allStores',

                'ng-init' => 'getStores(checkValuePreOrOld(\''.((!empty($discount->stores)) ? json_encode($discount->stores) : '').'\' , \''.((Input::old('stores')) ? json_encode(Input::old('stores')) : '').'\'));'

            ]

        )

    }}

    <input type="hidden" name="DiscountStore" mg-model="stores" ng-value="stores" />


</div>