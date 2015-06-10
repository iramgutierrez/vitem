<section class="panel" ng-show="tab == 'profile' ">
                          <div class="panel-heading">
                              <h2>Datos generales. </h2>
                          </div>
                          <div class="panel-body bio-graph-info">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $supplier->name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Correo electrónico </span><p class="col-sm-6"> {{ $supplier->email }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Teléfono </span><p class="col-sm-6"> {{ $supplier->phone }}</p>
                                  </div>                                  
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">RFC</span><p class="col-sm-6"> {{ $supplier->rfc }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Razón social</span><p class="col-sm-6"> {{ $supplier->business_name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Calle</span><p class="col-sm-6"> {{ $supplier->street }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Número exterior</span><p class="col-sm-6"> {{ $supplier->outer_number }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6"> Número interior</span><p class="col-sm-6"> {{ $supplier->inner_number }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Código postal</span><p class="col-sm-6"> {{ $supplier->zip_code }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Colonia</span><p class="col-sm-6"> {{ $supplier->colony }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Delegación o municipio</span><p class="col-sm-6"> {{ $supplier->city }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Estado</span><p class="col-sm-6"> {{ $supplier->state }}</p>
                                  </div>
                                  <!--<div class="col-sm-6">
                                      <span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $supplier->status ?>  | boolean }}</p>
                                  </div>-->
                              </div>
                          </div>
                      </section>