
<h4>Proveedor</h4>

<div class="col-sm-12">

    {{ Field::text

        (

            '',

            null ,

            [

                'class' => 'col-md-10' ,

                'addon-first' => '<i class="fa fa-search"></i>' ,

                'placeholder' => 'Busca por id, nombre o correo electrónico.',

                'ng-model' => '$root.find_supplier',

                'ng-change' => 'searchSupplier()',

                'ng-focus' => 'searchSupplier()',

                'ng-blur' => 'hideItems()'

            ]

        )

    }}

    {{ Field::hidden
        (

            'supplier_id',

            null ,

            [

                'ng-model' => '$root.supplier_id' ,

                'ng-value' => '$root.supplier_id' ,

                'ng-init' => 'supplierSelectedInit(checkValuePreOrOld("'.((!empty($devolution->supplier_id)) ? $devolution->supplier_id : '').'" , "'.((Input::old('supplier_id')) ? Input::old('supplier_id') : '').'" , "'.((!empty($supplier_id)) ? $supplier_id : '').'"))'


            ]

        );

    }}

</div>

<section ng-show="$root.autocompleteSupplier" class="panel col-sm-12">

    <ul class="list-group">

        <li ng-click="$root.addSupplier(supplier)" ng-repeat="supplier in suppliers" class="list-group-item " href="#">

            @{{supplier.name}}

        </li>

    </ul>

    <p ng-if="sellers.length == 0"> No se encontraron proveedores. </p>

</section>