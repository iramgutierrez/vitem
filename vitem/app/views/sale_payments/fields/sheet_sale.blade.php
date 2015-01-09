<div class="col-sm-12">

	@if(!$sale_id)  

	{{ Field::text

		(

			'sheet', 

			null 

		) 

	}}  

	@endif

	{{ Field::hidden

					(

						'sale_id', 

						$sale_id 

					) 

				}}  

</div>