<div class="col-sm-12">

	
	{{ Field::text

					(

						'sale_id', 

						$sale_id ,

						[
							'ng-model' => 'sale_id' ,

							'ng-init' => 'setSaleId('.$sale_id.')'
						]

					) 

				}}  

</div>