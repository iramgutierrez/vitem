<div class="col-sm-12">

	@if(!$sale_id)  

	<div class="col-sm-6">
	
		{{ Field::text

			(

				'sheet', 

				null ,

				[
					'ng-model' => 'sheet',

					'ng-init' => "setSaleSheet('".Input::old('sheet')."')"
				]

			) 

		}}  

	</div>

	<div class="col-sm-6">	

		{{ Form::button
			(

				'Buscar',

				[
					"ng-click" => "searchSaleBySheet()",

					"class" => "btn btn-success",

					"style" => "margin-bottom: -57px;"
				]
			) 
		}}

	</div>

	@endif

	{{ Field::hidden

					(

						'sale_id', 

						$sale_id ,

						[
							'ng-model' => 'sale_id' ,

							'ng-value' => 'sale_id' ,

							'ng-init' => 'setSaleId('.$sale_id.')'
						]

					) 

				}}  

	
</div>

<div class="clearfix"></div>