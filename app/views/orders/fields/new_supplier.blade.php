<!-- Modal -->
<div class="modal fade" id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar nuevo proveedor</h4>
            </div>
            <div class="modal-body">

                {{ Form::model( new Supplier ,['route' => 'suppliers.store',  'name' => 'addsupplierForm' , 'id' => 'addsupplierForm', 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'AddSupplierController' , 'ng-init' => 'initJQuery(); '  ]) }}

                <div class="form-group col-md-6 col-sm-12">

                    {{ Field::text(
                    'name',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el nombre completo',
                    'required',
                    'ng-model' => 'client.name'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'email',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el correo electrónico'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'rfc',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el RFC'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'business_name',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa la razón social'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'phone',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el teléfono'
                    ]
                    )
                   }}
                </div>

                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'street',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa la calle de la dirección'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'outer_number',
                    '' ,
                    [
                     'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el número exterior'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'inner_number',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el número interior'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'zip_code',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el código postal'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'colony',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa la colonia'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'city',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa la ciudad, delegación o municipio'
                    ]
                    )
                  }}
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    {{ Field::text(
                    'state',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el estado'
                    ]
                    )
                  }}
                </div>


                <div class="form-group col-md-12 ">
                    <button data-dismiss="modal" class="btn btn-default close_modal" type="button">Cerrar</button>
                    <button type="submit" class="btn btn-success pull-right" >Registrar</button>
                </div>

                {{ Form::close() }}

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- modal -->