<div class="col-sm-12" ng-init=" 
@if(Input::old('PackProduct'))
  @foreach(Input::old('PackProduct') as $k => $p)    
            productsOld.push({
              product_id : '{{ $k }}',
              quantity : '{{ $p['quantity'] }}'
            });    
  @endforeach
  getProductsOld();
@else
  getProductsSelected({{ $pack->id }} );
@endif 

" >

  <table class="table table-bordered table-striped table-condensed" ng-if="productsSelected.length">
    
    <thead>
                  
        <tr>

        <th>Id</th>

        <th>Nombre</th>

        <th>Código</th>

        <th>Modelo / Descripción</th>

        <th>En existencia</th>

        <th>Precio Unitario</th>

        <th class="col-sm-2">Cantidad</th>

        <th>Precio</th>

        <th>Borrar</th>
        
      </tr>

      </thead>

      <tbody>
                                    
      	<tr ng-repeat="(k , product) in productsSelected" >
      
  	    	<td>

  	        	@{{product.id }}

  	      	</td>

  	      	<td> @{{product.name }}</td>

  	      	<td> @{{product.key }}</td>

  		    <td> @{{product.model }}</td>

  		    <td> @{{product.stock }}</td>

  		    <td> @{{product.price | currency }}</td>

  		    <td>
          
          		<div id="spinner1 col-sm-2">
                  
                    <div class="input-group input-small">
                      
                        <input type="text" class="spinner-input form-control" maxlength="3" ng-model="product.quantity" ng-init="product.quantity = quantityInit(product)" name="PackProduct[@{{ product.id }}][quantity]" >
                      
                        <div class="spinner-buttons input-group-btn btn-group-vertical">
                        
                          <button ng-click= "product.quantity = addQuantity(product.quantity , product.stock)" type="button" class="btn spinner-up btn-xs btn-default">
                            
                              <i class="fa fa-angle-up"></i>

                            </button>
                            
                            <button ng-click= "product.quantity = removeQuantity(product.quantity)" type="button" class="btn spinner-down btn-xs btn-default">
                            
                              <i class="fa fa-angle-down"></i>
                            
                            </button>
                        
                        </div>
                    
                    </div>
                          
                  </div>
        
        		</td>

        		<td> @{{ pricePerQuantity(product.price , product.quantity) | currency  }}</td>

        		<td>

  		    	<button type="button" class="col-sm-12 btn btn-danger" ng-click="removeProduct(k)" >

  		          <i class="fa fa-times"></i>

  		        </button>

  		    </td>

      	</tr>      	

      	<tr>

  	    	<td colspan="5"></td>

  	      	<td colspan="2" class="text-right">

  	        	<b>Total</b>

  	      	</td>

        		<td colspan="2">

          		@{{ getTotalPrice() | currency }}

        		</td>

      	</tr>

      </tbody>  

  </table>   

</div>
	    