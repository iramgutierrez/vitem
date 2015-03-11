 <section class="panel" ng-show="tab == 'profile'">
                          <div class="panel-heading">
                              <h2>Datos personales. </h2>
                          </div>
                          <div class="panel-body bio-graph-info">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $client->name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Correo electrónico </span><p class="col-sm-6"> {{ $client->email }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">RFC</span><p class="col-sm-6"> {{ $client->rfc }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Razón social</span><p class="col-sm-6"> {{ $client->business_name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Calle</span><p class="col-sm-6"> {{ $client->street }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Número exterior</span><p class="col-sm-6"> {{ $client->outer_number }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6"> Número interior</span><p class="col-sm-6"> {{ $client->inner_number }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Código postal</span><p class="col-sm-6"> {{ $client->zip_code }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Colonia</span><p class="col-sm-6"> {{ $client->colony }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Delegación o municipio</span><p class="col-sm-6"> {{ $client->city }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Estado</span><p class="col-sm-6"> {{ $client->state }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Teléfono </span><p class="col-sm-6"> {{ $client->phone }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Tipo de empleado </span><p class="col-sm-6"> {{ $client->client_type->name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Fecha de ingreso </span><p class="col-sm-6"> {{ $client->entry_date }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $client->status ?>  | boolean }}</p>
                                  </div>
                              </div>
                          </div>
                      </section>