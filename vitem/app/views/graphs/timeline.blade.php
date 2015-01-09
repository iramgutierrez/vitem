<section class="panel" ng-controller="TimelineController">
                          <div class="panel-body">
                                  <div class="text-center mbot30">
                                      <h3 class="timeline-title">Linea de tiempo.</h3>
                                      <p class="t-info">Estos son las últimas acciones en el sistema.</p>
                                  </div>
                                  <div class="timelineContent">
	                                  <div class="timeline">
	                                      <article class="timeline-item" ng-class="{alt : k%2}" ng-repeat="(k, record) in records">
	                                          <div class="timeline-desk">
	                                              <div class="panel">
	                                                  <div class="panel-body">
	                                                      <span class="arrow"></span>
	                                                      <span class="timeline-icon " ng-class="{ red:record.type==4 ,  blue:record.type==3 ,  green:record.type==1 }"></span>
	                                                      <span class="timeline-date">@{{ record.unix_time*1000 | date:'hh:mm a' }}</span>
	                                                      <h1 ng-class="{ red:record.type==4 ,  blue:record.type==3 ,  green:record.type==1 }">@{{ record.unix_time*1000 | date:' dd - 	MMMM | EEEE ' }}</h1>
	                                                      <p>El usuario <a href="@{{record.user.url_show}}">@{{record.user.username}}</a> @{{ record.message }}</p>
	                                                      	<a  ng-class="{ red:record.type==4 ,  blue:record.type==3 ,  green:record.type==1 }" ng-if="record.object_array.url_show && record.type!=4" href="@{{record.object_array.url_show}}" class="pull-right">
	                                                      		Ver
	                                                      	</a>
	                                                  </div>
	                                              </div>
	                                          </div>
	                                      </article>
	                                  </div>
                                  </div>

                                  <div class="clearfix">&nbsp;</div>
                              </div>
                      </section>