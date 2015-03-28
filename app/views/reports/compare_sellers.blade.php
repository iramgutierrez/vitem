@extends('layout')

@section('header')

@include('header' , [ 'css' => []
]
)

@stop

@section('sidebar_left')

@include('sidebar_left')

@stop

@section('content')




<div ng-app="compare_sellers" >

	<div class="adv-table" ng-controller="Controller">
		<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
					<h1 class="col-sm-12">Comparador de vendedores</h1>
				</header>  			 	
				<hr>

	  	  		<div class="form-group col-md-6 col-sm-12 " >

	  	  			 @include('reports/compare_sellers/seller_1')

	  	    	</div> 

	  	  		<div class="form-group col-md-6 col-sm-12 " >

	  	  			 @include('reports/compare_sellers/seller_2')

	  	    	</div>

	  	  		<div class="form-group col-md-6 col-sm-6 " >

	  	  			 @include('reports/compare_sellers/init_date')

	  	    	</div>

	  	  		<div class="form-group col-md-6 col-sm-6 " >

	  	  			 @include('reports/compare_sellers/end_date')

	  	    	</div>

	  	    	<div class="form-group col-sm-1 col-sm-offset-11">

	  	    		<button class="btn btn-success col-sm-12" ng-disabled="!employee_id_1 || !employee_id_2 || !init_date || !end_date" ng-click="getCompareSellers();">Ver </button>

	  	    	</div>

	  	  		<div class="form-group col-md-12 col-sm-12 " >

	  	  			 @include('reports/compare_sellers/table')

	  	    	</div>
			   
			</div>
		</div> 
	</div>

</div>


@stop

@section('sidebar_right')

@include('sidebar_right')

@stop


@section('footer')

@include('footer', ['js' => [
		'library/js/jquery-ui-1.9.2.custom.min.js' ,
        'library/js/ng/compare_sellers.js',
        'library/js/ng/users.services.js',
        'library/js/ng/users.filters.js',
        'library/js/ng/directives.js',
        'library/js/ng/date.format.js',
]
]
)

@stop