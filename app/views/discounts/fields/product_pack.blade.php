<div class="col-sm-12" ng-init="
@if(Input::old('ProductSale'))
  @foreach(Input::old('ProductSale') as $k => $p)
            productsOld.push({
              product_id : '{{ $k }}',
              quantity : '{{ $p['quantity'] }}'
            });
  @endforeach
        getProductsOld();
      @endif

@if(Input::old('PackSale'))
  @foreach(Input::old('PackSale') as $k => $p)
            packsOld.push({
              pack_id : '{{ $k }}',
              quantity : '{{ $p['quantity'] }}'
            });
  @endforeach
        getPacksOld();
      @endif

        " >

    <table class="table table-bordered table-striped table-condensed" >

        <thead>

        <tr>

            <th class="col-sm-1">Id</th>

            <th class="col-sm-2">Nombre</th>

            <th class="col-sm-1">Tipo</th>

            <th class="col-sm-2">Código</th>

            <th class="col-sm-2">Precio unitario</th>

            <th class="col-sm-2">Precio</th>

            <th class="col-sm-2">Cantidad</th>

            <th class="col-sm-2">Precio con descuento</th>

        </tr>

        </thead>

        <tbody>

            <tr>

            <td>

                @{{uniqueItem.id }}

            </td>

            <td> @{{uniqueItem.name }}</td>

            <td> @{{ uniqueItem.type }} </td>

            <td> @{{uniqueItem.key }}</td>

            <td> @{{uniqueItem.price | currency }}</td>

            <td> @{{uniqueItem.price * uniqueItem.quantity | currency }}</td>

            <td>

                <div id="spinner1 col-sm-2">

                    <div class="input-group input-small">

                        <input type="text" class="spinner-input form-control" maxlength="3" ng-model="uniqueItem.quantity" name="item_quantity" >

                        <div class="spinner-buttons input-group-btn btn-group-vertical">

                            <button ng-click= "uniqueItem.quantity = addQuantity(uniqueItem.quantity)" type="button" class="btn spinner-up btn-xs btn-default">

                                <i class="fa fa-angle-up"></i>

                            </button>

                            <button ng-click= "uniqueItem.quantity = removeQuantity(uniqueItem.quantity)" type="button" class="btn spinner-down btn-xs btn-default">

                                <i class="fa fa-angle-down"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </td>

            <td> @{{uniqueItem.discount_price * uniqueItem.quantity | currency }}</td>

        </tr>

        </tbody>

    </table>

    <input type="text" name="item_type" ng-value="tab" ng-model="tab" ng-if="type == 1" />
    <input type="text" name="item_id" ng-value="uniqueItem.id" ng-model="uniqueItem.id" />

</div>
