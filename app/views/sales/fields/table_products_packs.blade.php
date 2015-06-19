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

        <th>Id</th>

        <th>Nombre</th>

        <th>Tipo</th>

        <th>Código</th>

        <th>Modelo / Descripción</th>

        <th>En existencia</th>

        <th>Precio Unitario</th>

        <th class="col-sm-2">Cantidad</th>

        <th>Precio</th>

        <th>Borrar</th>
        
      </tr>

      </thead>

      <tbody ng-repeat="(k , product) in $root.productsSelected">
                                    
      	<tr ng-class="{ quantity_null : product.quantity_null  }">
      
  	    	<td>

  	        	@{{product.id }}

  	      	</td>

  	      	<td> @{{product.name }}</td>

  	      	<td> Producto </td>

  	      	<td> @{{product.key }}</td>

  		    <td> @{{product.model }}</td>

  		    <td> @{{ product.stock }}</td>

  		    <td> @{{product.price | currency }}</td>

  		    <td>
          
          		<div id="spinner1 col-sm-2">
                  
                    <div class="input-group input-small">
                      
                        <input type="text" class="spinner-input form-control" maxlength="3" ng-model="product.quantity" name="ProductSale[@{{ product.id }}][quantity]" >
                      
                        <div class="spinner-buttons input-group-btn btn-group-vertical">
                        
                          <button ng-disabled="product.quantity_null" ng-click= "product.quantity = addQuantity(product.quantity , product.stock)" type="button" class="btn spinner-up btn-xs btn-default">
                            
                              <i class="fa fa-angle-up"></i>

                            </button>
                            
                            <button ng-disabled="product.quantity_null" ng-click= "product.quantity = removeQuantity(product.quantity)" type="button" class="btn spinner-down btn-xs btn-default">
                            
                              <i class="fa fa-angle-down"></i>
                            
                            </button>
                        
                        </div>
                    
                    </div>
                          
                  </div>

                  <button type="button" class="btn btn-primary col-sm-12" style="margin-top: 10px" ng-click="showColors(product); " ng-show="!product.showColors" >Mostrar colores</button>

                  <button type="button" class="btn btn-primary col-sm-12" style="margin-top: 10px" ng-click="showColors(product); " ng-show="product.showColors" >Ocultar colores</button>
        
        		</td>

        		<td> @{{ pricePerQuantity(product.price , product.quantity) | currency  }}</td>

        		<td>

  		    	<button type="button" class="col-sm-12 btn btn-danger" ng-click="removeProduct(k)" >

  		          <i class="fa fa-times"></i>

  		        </button>

  		    </td>

      	</tr>

        <tr ng-if="product.showColors">
          <td colspan="7" class="text-right">Cantidad sin asignar color</td>
          <td>@{{ getProductsWithoutColors(product) }}</td> 
          <td></td>
          <td></td>
        </tr>

        <tr ng-if="product.showColors && product.colors.length">
          <td colspan="5"></td>
          <td>Color</td>
          <td>Disponibles</td>
          <td>Asignados</td>
          <td></td>
          <td></td>
        </tr>

        <tr ng-if="product.showColors && !product.colors.length">
          <td colspan="8" class="text-right">Este producto no tiene colores asignados</td>
          <td></td>
          <td></td>
        </tr>

        <tr  ng-show="product.showColors && product.colors.length" ng-repeat="(c , color)  in product.colors">
          <td colspan="5"></td>
          <td>@{{ color.name }}</td>
          <td>@{{ color.pivot.quantity }}</td>
          <td>
            <select class="form-control" ng-model="product.assignedColors[c]" name="ColorProductSale[@{{color.pivot.id}}][quantity]" ng-change="getProductsWithoutColors(product)" >
              <option value="0">0</option>
              <option ng-repeat="n in [] | range:getMaxProductColor(getProductsWithoutColors(product) , color.pivot.quantity , product.assignedColors[c])" value="@{{ n+1 }}">@{{ n+1 }}</option>
            </select>
          </td>
          <td></td>
          <td></td>
        </tr>
        

      </tbody>

      <tbody>

      	<tr ng-repeat="(k , pack) in packsSelected" >
      
  	    	<td> @{{pack.id }}</td>

  	      	<td> @{{pack.name }}</td>

  	      	<td> Paquete </td>

  	      	<td> @{{pack.key }}</td>

  		    <td> @{{pack.description }}</td>

  		    <td> </td>

  		    <td> @{{pack.price | currency }}</td>

  		    <td>
          
          		<div id="spinner1 col-sm-2">
                  
                    <div class="input-group input-small">
                      
                        <input type="text" class="spinner-input form-control" maxlength="3" ng-model="pack.quantity" name="PackSale[@{{ pack.id }}][quantity]" >
                      
                        <div class="spinner-buttons input-group-btn btn-group-vertical">
                        
                          <button ng-click= "pack.quantity = addQuantity(pack.quantity )" type="button" class="btn spinner-up btn-xs btn-default">
                            
                              <i class="fa fa-angle-up"></i>

                            </button>
                            
                            <button ng-click= "pack.quantity = removeQuantity(pack.quantity)" type="button" class="btn spinner-down btn-xs btn-default">
                            
                              <i class="fa fa-angle-down"></i>
                            
                            </button>
                        
                        </div>
                    
                    </div>
                          
                  </div>
        
        		</td>

        		<td> @{{ pricePerQuantity(pack.price , pack.quantity) | currency  }}</td>

        		<td>

  		    	<button type="button" class="col-sm-12 btn btn-danger" ng-click="removePack(k)" >

  		          <i class="fa fa-times"></i>

  		        </button>

  		    </td>

      	</tr>

      	<tr>

  	    	<td colspan="6"></td>

  	      	<td colspan="2" class="text-right">

  	        	<b>Total de venta</b>

  	      	</td>

        		<td colspan="2">

          		@{{ getTotalPrice() | currency }}

        		</td>

      	</tr>

        <tr>

          <td colspan="6"></td>

            <td colspan="2" class="text-right">

              <b>Costo de la entrega</b>

            </td>

            <td colspan="2">

              @{{ getDeliveryCost() | currency }}

            </td>

        </tr>

        <tr>

          <td colspan="6"></td>

            <td colspan="2" class="text-right">

              <b>Comisión por foma de pago (@{{ percent_commission }}%)</b>

            </td>

            <td colspan="2">

              @{{ getCommissionPay() | currency }}

            </td>

        </tr>

        <tr>

          <td colspan="6"></td>

            <td colspan="2" class="text-right">

              <b>Total</b>

            </td>

            <td colspan="2">

              @{{ getFinalPrice() | currency }}

            </td>

        </tr>

      </tbody>  

  </table>   

</div>
	    