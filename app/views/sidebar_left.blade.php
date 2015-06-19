<!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a class="active" href="{{ route('dashboard') }}">
                          <i class="fa fa-dashboard"></i>
                          <span>Panel general</span>
                      </a>
                  </li>

                  @if(Auth::user()->role->level_id >= 2)
                  <li class="sub-menu" data-entities="user" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-users"></i>
                          <span>Usuarios</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="user" data-actions="read" data-permissions ><a  href="{{ route('users.index') }}">Ver todos</a></li>
                          <li data-entities="user" data-actions="create" data-permissions ><a  href="{{ route('users.create') }}">Agregar usuario</a></li>
                      </ul>
                  </li>
                  @endif

                  @if(Auth::user()->role->level_id >= 2)
                  <li class="sub-menu" data-entities="role" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-users"></i>
                          <span>Roles</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="role" data-actions="read" data-permissions ><a  href="{{ route('roles.index') }}">Ver todos</a></li>
                          <li data-entities="role" data-actions="create" data-permissions ><a  href="{{ route('roles.create') }}">Agregar rol</a></li>
                      </ul>
                  </li>
                  @endif

                  @if(Auth::user()->role->level_id >= 3)

                  <li class="sub-menu" data-entities="store" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-home"></i>
                          <span>Sucursales</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="sale" data-actions="read" data-permissions ><a  href="{{ route('stores.index') }}">Ver todas</a></li>
                          <li data-entities="store" data-actions="create" data-permissions ><a  href="{{ route('stores.create') }}">Agregar sucursal</a></li>
                      </ul>
                  </li>
                  @endif

                  <li class="sub-menu" data-entities="product" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Productos</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="product" data-actions="read" data-permissions ><a  href="{{ route('products.index') }}">Ver todos</a></li>
                          <li data-entities="product" data-actions="create" data-permissions ><a  href="{{ route('products.create') }}">Agregar producto</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu" data-entities="pack" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Paquetes</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="sale" data-actions="read" data-permissions ><a  href="{{ route('packs.index') }}">Ver todos</a></li>
                          <li data-entities="pack" data-actions="create" data-permissions ><a  href="{{ route('packs.create') }}">Agregar paquete</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu" data-entities="sale,sale_payment,commission,delivery" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Ventas</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="sale" data-actions="read" data-permissions ><a  href="{{ route('sales.index') }}">Ver todas</a></li>
                          <li data-entities="sale" data-actions="create" data-permissions ><a  href="{{ route('sales.create') }}">Agregar venta</a></li>
                          <li data-entities="sale_payment" data-actions="create" data-permissions ><a  href="{{ route('sale_payments.create') }}">Agregar abono</a></li>
                          <li data-entities="commission" data-actions="create" data-permissions ><a  href="{{ route('commissions.create') }}">Agregar comisiones</a></li>
                          <li data-entities="delivery" data-actions="create" data-permissions ><a  href="{{ route('deliveries.create') }}">Agregar entrega</a></li>
                      </ul>
                  </li>

                  @if(Auth::user()->role->level_id >= 2)

                  <li class="sub-menu" data-entities="supplier" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-truck"></i>
                          <span>Proveedores</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="supplier" data-actions="read" data-permissions ><a  href="{{ route('suppliers.index') }}">Ver todos</a></li>
                          <li data-entities="supplier" data-actions="create" data-permissions ><a  href="{{ route('suppliers.create') }}">Agregar proveedor</a></li>
                      </ul>
                  </li>

                  @endif

                  @if(Auth::user()->role->level_id >= 2)

                  <li class="sub-menu" data-entities="delivery" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-map-marker"></i>
                          <span>Entregas</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="delivery" data-actions="read" data-permissions ><a  href="{{ route('deliveries.index') }}">Ver todas</a></li>
                          <li data-entities="delivery" data-actions="create" data-permissions ><a  href="{{ route('deliveries.create') }}">Agregar entrega</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Auth::user()->role->level_id >= 2)
                  <li class="sub-menu" data-entities="destination" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-map-marker"></i>
                          <span>Destinos para entregas</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="destination" data-actions="read" data-permissions ><a  href="{{ route('destinations.index') }}">Ver todos</a></li>
                          <li data-entities="destination" data-actions="create" data-permissions ><a  href="{{ route('destinations.create') }}">Agregar destino</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Auth::user()->role->level_id >= 2)
                  <li class="sub-menu" data-entities="order" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-truck"></i>
                          <span>Pedidos</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="order" data-actions="read" data-permissions ><a  href="{{ route('orders.index') }}">Ver todos</a></li>
                          <li data-entities="order" data-actions="create" data-permissions ><a  href="{{ route('orders.create') }}">Agregar pedido</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Auth::user()->role->level_id >= 2)
                  <li class="sub-menu" data-entities="client" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-users"></i>
                          <span>Clientes</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="client" data-actions="read" data-permissions ><a  href="{{ route('clients.index') }}">Ver todos</a></li>
                          <li data-entities="client" data-actions="create" data-permissions ><a  href="{{ route('clients.create') }}">Agregar cliente</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Auth::user()->role->level_id >= 2)
                  <li class="sub-menu" data-entities="expense" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-dollar"></i>
                          <span>Gastos</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="expense" data-actions="read" data-permissions ><a  href="{{ route('expenses.index') }}">Ver todos</a></li>
                          <li data-entities="expense" data-actions="create" data-permissions ><a  href="{{ route('expenses.create') }}">Agregar gasto</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Auth::user()->role->level_id >= 3)
                  <li class="sub-menu" data-entities="sale,user" data-actions="read" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-dollar"></i>
                          <span>Reportes</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="sale" data-actions="read" data-permissions ><a  href="{{ route('reports.sales') }}">Reporte de ventas</a></li>
                          <li data-entities="user" data-actions="read" data-permissions ><a  href="{{ route('reports.compare_sellers') }}">Comparador de vendedores</a></li>
                          <li data-entities="user" data-actions="read" data-permissions ><a  href="{{ route('reports.compare_drivers') }}">Comparador de choferes</a></li>
                      </ul>
                  </li>
                  @endif

                  @if(Auth::user()->role->level_id >= 2)

                  <li class="sub-menu"  data-entities="setting,pay_type,expense_type,client_type" data-actions="read,create" data-permissions >
                      <a href="javascript:;" >
                          <i class="fa fa-cogs"></i>
                          <span>Configuraciónes</span>
                      </a>
                      <ul class="sub">
                          <li data-entities="setting" data-actions="read,create" data-permissions ><a  href="{{ route('settings.index') }}">Configuraciones generales</a></li>
                          <li data-entities="pay_type" data-actions="read" data-permissions ><a  href="{{ route('pay_types.index') }}">Terminales de pago</a></li>
                          <li data-entities="expense_type" data-actions="read" data-permissions ><a  href="{{ route('expense_types.index') }}">Tipos de gastos</a></li>
                          <li data-entities="client_type" data-actions="read" data-permissions ><a  href="{{ route('client_types.index') }}">Tipos de clientes</a></li>
                          <li data-entities="color" data-actions="read" data-permissions ><a  href="{{ route('colors.index') }}">Colores</a></li>
                      </ul>
                  </li>

                  @endif
                  <!--<li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-book"></i>
                          <span>UI Elements</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="general.html">General</a></li>
                          <li><a  href="buttons.html">Buttons</a></li>
                          <li><a  href="widget.html">Widget</a></li>
                          <li><a  href="slider.html">Slider</a></li>
                          <li><a  href="nestable.html">Nestable</a></li>
                          <li><a  href="font_awesome.html">Font Awesome</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-cogs"></i>
                          <span>Components</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="grids.html">Grids</a></li>
                          <li><a  href="calendar.html">Calendar</a></li>
                          <li><a  href="gallery.html">Gallery</a></li>
                          <li><a  href="todo_list.html">Todo List</a></li>
                          <li><a  href="draggable_portlet.html">Draggable Portlet</a></li>
                          <li><a  href="tree.html">Tree View</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-tasks"></i>
                          <span>Form Stuff</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="form_component.html">Form Components</a></li>
                          <li><a  href="advanced_form_components.html">Advanced Components</a></li>
                          <li><a  href="form_wizard.html">Form Wizard</a></li>
                          <li><a  href="form_validation.html">Form Validation</a></li>
                          <li><a  href="dropzone.html">Dropzone File Upload</a></li>
                          <li><a  href="inline_editor.html">Inline Editor</a></li>
                          <li><a  href="image_cropping.html">Image Cropping</a></li>
                          <li><a  href="file_upload.html">Multiple File Upload</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-th"></i>
                          <span>Data Tables</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="basic_table.html">Basic Table</a></li>
                          <li><a  href="responsive_table.html">Responsive Table</a></li>
                          <li><a  href="dynamic_table.html">Dynamic Table</a></li>
                          <li><a  href="editable_table.html">Editable Table</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-envelope"></i>
                          <span>Mail</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="inbox.html">Inbox</a></li>
                          <li><a  href="inbox_details.html">Inbox Details</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Charts</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="morris.html">Morris</a></li>
                          <li><a  href="chartjs.html">Chartjs</a></li>
                          <li><a  href="flot_chart.html">Flot Charts</a></li>
                          <li><a  href="xchart.html">xChart</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Shop</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="product_list.html">List View</a></li>
                          <li><a  href="product_details.html">Details View</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="google_maps.html" >
                          <i class="fa fa-map-marker"></i>
                          <span>Google Maps </span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-comments-o"></i>
                          <span>Chat Room</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="lobby.html">Lobby</a></li>
                          <li><a  href="chat_room.html"> Chat Room</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-glass"></i>
                          <span>Extra</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="blank.html">Blank Page</a></li>
                          <li><a  href="sidebar_closed.html">Sidebar Closed</a></li>
                          <li><a  href="people_directory.html">People Directory</a></li>
                          <li><a  href="coming_soon.html">Coming Soon</a></li>
                          <li><a  href="lock_screen.html">Lock Screen</a></li>
                          <li><a  href="profile.html">Profile</a></li>
                          <li><a  href="invoice.html">Invoice</a></li>
                          <li><a  href="search_result.html">Search Result</a></li>
                          <li><a  href="pricing_table.html">Pricing Table</a></li>
                          <li><a  href="faq.html">FAQ</a></li>
                          <li><a  href="fb_wall.html">FB Wall</a></li>
                          <li><a  href="404.html">404 Error</a></li>
                          <li><a  href="500.html">500 Error</a></li>
                      </ul>
                  </li>
                  <li>
                      <a  href="login.html">
                          <i class="fa fa-user"></i>
                          <span>Login Page</span>
                      </a>
                  </li>-->

                  <!--multi level menu start-->
                  <!--<li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-sitemap"></i>
                          <span>Multi level Menu</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="javascript:;">Menu Item 1</a></li>
                          <li class="sub-menu">
                              <a  href="boxed_page.html">Menu Item 2</a>
                              <ul class="sub">
                                  <li><a  href="javascript:;">Menu Item 2.1</a></li>
                                  <li class="sub-menu">
                                      <a  href="javascript:;">Menu Item 3</a>
                                      <ul class="sub">
                                          <li><a  href="javascript:;">Menu Item 3.1</a></li>
                                          <li><a  href="javascript:;">Menu Item 3.2</a></li>
                                      </ul>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </li>-->
                  <!--multi level menu end-->

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->