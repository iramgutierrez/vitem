<div class="col-lg-12" ng-controller="GraphController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" ng-show="$root.auth_permissions.read.sale || $root.auth_permissions.read.sale_payment" >
	<!--custom chart start-->
    <div class="border-head" style="height: 100px;">
    
        <h3>Ingresos</h3>

        <div class="col-sm-2" ng-show="$root.auth_permissions.read.sale">

	        {{ Field::checkbox

				(
					'',
					null ,
					[
						'ng-model' => 'showSales' ,
		                'ng-change' => 'getData()',
		                'ng-disabled' => '!$root.auth_permissions.read.sale || !$root.auth_permissions.read.sale_payment'
					],
					[
						'label-value' => 'Ventas'
					]
				)
			}}

		</div>
		<div class="col-sm-2" ng-show="$root.auth_permissions.read.sale_payment" >

	        {{ Field::checkbox

				(
					'',
					null ,
					[
						'ng-model' => 'showSalePayments' ,
		                'ng-change' => 'getData()',
		                'ng-disabled' => '!$root.auth_permissions.read.sale || !$root.auth_permissions.read.sale_payment'
					],
					[
						'label-value' => 'Abonos'
					]
				)
			}}

		</div>
		<div class="col-sm-2" >

	        {{ Field::date

				(
					'init_date', 
					'' ,
					[ 	                
		                'ng-model' => 'initDate',
		                'ng-init' => 'setDates('.date('Y , m , d' , time() - (60*60*24*7)).' , '.date('Y , m , d' , ( time()  ) ).')',
		                'ng-change' => 'getData()'
		            ]
				) 
			}} 

		</div>

		<div class="col-sm-2" >

	        {{ Field::date

				(
					'end_date', 
					'' ,
					[ 	                
		                'ng-model' => 'endDate',
		                'ng-change' => 'getData()'
		            ]
				) 
			}} 

		</div>
		<div class="col-sm-2">

			{{ Field::select
				(
					'show_by', 
					[
						'day' => 'Por día',
						'week' => 'Por semana',
						'month' => 'Por mes'
					],
					null ,
					[	                
		                'ng-model' => 'showBy',
		                'ng-change' => 'getData()'	,
		                'class' => 'styled' 
		            ]
				) 
			}}   

		</div>
                          
                      </div>
                      <div class="custom-bar-chart">
                          <ul class="y-axis">
                              <li><span>@{{ round(max) | currency }}</span></li>
                              <li><span>@{{ round(max*(4/5)) | currency }}</span></li>
                              <li><span>@{{ round(max*(3/5)) | currency }}</span></li>
                              <li><span>@{{ round(max*(2/5)) | currency }}</span></li>
                              <li><span>@{{ round(max*(1/5)) | currency }}</span></li>
                              <li><span>@{{ round(max*(0/5)) | currency }}</span></li>
                          </ul>
                          <div class="barsContent">
                            <div class="bars" style="width: @{{ widthContentBars }}px;">
                              <div class="bar" ng-repeat="(key_total , total) in totalByRange" >
                                  <div class="title">@{{ key_total }}<br> @{{total | currency}}</div>
                                  <div class="value tooltips" data-original-title="dfadfasdf" data-percent="100%" data-toggle="tooltip" data-placement="top">@{{ getPercent(total); }}</div>
                                  <div ></div>
                              </div>
                            </div>
                          </div>                         
                      </div>
                      <!--custom chart end-->
                  </div>

                  <div class="border-head">
                    <h3></h3>
                  </div>          