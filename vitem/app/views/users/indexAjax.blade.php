<header class="panel-heading">
    <h1>Usuarios</h1>
</header>


<div class="panel-body"  ng-app="users">
    <div class="adv-table" ng-controller="UsersController">
        {{ Field::text(
                '', 
                '' , 
                [ 
                    'class' => 'col-md-10' , 
                    'addon-first' => '<i class="fa fa-search"></i>' , 
                    'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',
                    'ng-model' => 'find',
                    'ng-change' => 'search()'

                ]
            ) 
        }}
        <hr>
        <div class="col-sm-12">
            <p class="col-sm-2"><span class="badge bg-success">@{{users.length}}</span> usuarios</p>        
            <button type="button" ng-click="clear()" class="pull-right btn btn-info">Limpiar filtros</button>
        </div>
        <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table">
            <thead>
                <tr >
                    <th class="col-sm-1">                        
                        <a href="" ng-click="sort = 'id'; reverse=!reverse">Id
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'id' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'id' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'name'; reverse=!reverse">Nombre
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'email'; reverse=!reverse">Correo electrónico
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'email' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'email' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'email' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1">
                        <a href="" ng-click="sort = 'username'; reverse=!reverse">Usuario
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'username' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'username' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'username' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a class="col-sm-12" href="" ng-click="sort = 'role.name'; reverse=!reverse">Tipo
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'role.name'  && type == ''"></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'role.name' && reverse == false && type == ''"></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'role.name' && reverse == true && type == ''"></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'employee.salary'; reverse=!reverse">Salario
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'employee.salary' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'employee.salary' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'employee.salary' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2"></th>
                    <!--<th class="hidden-phone">Nombre de usuario</th>
                    <th class="hidden-phone"></th>-->
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <span class="">
                            {{ Field::select(
                                                        '', 
                                                        $roles,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'type',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                    </th>
                    <th>
                        <span class="col-sm-12">
                            {{ Field::select(
                                                        '', 
                                                        $filtersSalary,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'operatorSalary',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                        <span class="col-sm-12">
                            {{ Field::text(
                                                        '', 
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'salary',
                                                            'ng-change' => 'search()',                                                    
                                                        ]
                                                ) 
                                        }}
                        </span>
                        
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="gradeX" ng-repeat="user in users | orderBy:sort:reverse">
                    <td>@{{ user.id }}</td>
                    <td>@{{ user.name }}</td>
                    <td>@{{ user.email }}</td>
                    <td>@{{ user.username }}</td>
                    <td>@{{ user.role.name }}</td>
                    <td>@{{ user.employee.salary | currency }}</td>
                    <td>
                        <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
                        <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>


                    </td>
                </tr>              
            </tbody>
        </table>
    </div>
</div>