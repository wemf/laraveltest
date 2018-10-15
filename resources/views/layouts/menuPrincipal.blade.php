<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li>
                <a href="{{ url('/home') }}">
                    <i class="fa fa-home"></i> Inicio
                    <span class=""></span>
                </a>
            </li>
            @if(Auth::user()->inFuncionalidades(['admonGeneral.general','admonGeneral.locacion.pais','admonGeneral.locacion.dpto','admonGeneral.locacion.ciudad','admonGeneral.sociedad.nombreCom', 'admonGeneral.sociedad.sociedad', 'admonGeneral.sociedad.zona', 'admonGeneral.sociedad.tienda', 'admonGeneral.sociedad.secueTienda', 'admonGeneral.estado.estado', 'admonGeneral.diaFestivo', 'gestionCliente.parametro.tipoTrabajo','gestionCliente.parametro.areaTrabajo','gestionCliente.parametro.tipoDocumento','gestionCliente.parametro.profesion', 'gestionCliente.parametro.calificacion', 'gestionCliente.parametro.pasaTiempo', 'gestionCliente.parametro.confiabilidad', 'gestionCliente.parametro.cargoEmpleado', 'gestionCliente.parametro.motivoRetiro','gestionCliente.parametro.eps', 'gestionCliente.parametro.cajaComp', 'gestionProducto.asociarGeneral','gestionProducto.atributoProducto','gestionProducto.valorAtributo','gestionProducto.catalogoProducto', 'configContrato.configGeneral','configContrato.configEspecifica','configContrato.configDiaGracia','configContrato.configRetroventa','configContrato.configContrato','configContrato.configPrecio', 'gestionContabilidad.plan1cuenta','admonGeneral.denominacionmoneda']))
            <li>
                <a>
                    <i class="fa fa-cogs"></i> Parámetros Generales
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    @if(Auth::user()->inFuncionalidades(['admonGeneral.general','admonGeneral.locacion.pais','admonGeneral.locacion.dpto','admonGeneral.locacion.ciudad','admonGeneral.sociedad.nombreCom', 'admonGeneral.sociedad.sociedad', 'admonGeneral.sociedad.zona', 'admonGeneral.sociedad.tienda', 'admonGeneral.sociedad.secueTienda', 'admonGeneral.estado.estado', 'admonGeneral.diaFestivo','admonGeneral.denominacionmoneda']))
                    <li>
                        <a> Configuración General
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if(Auth::user()->inFuncionalidades(['admonGeneral.locacion.pais','admonGeneral.locacion.dpto','admonGeneral.locacion.ciudad']))
                            <li>
                                <a> Locaciones
                                    <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.locacion.pais'))
                                    <li>
                                        <a href="{{ url('/pais') }}">Países</a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.locacion.dpto'))
                                    <li>
                                        <a href="{{ url('/departamento') }}">Departamentos</a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.locacion.ciudad'))
                                    <li>
                                        <a href="{{ url('/ciudad') }}">Ciudades</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('admonGeneral.general'))
                            <li>
                                <a href="{{ url('/parametros') }}"> Datos del País</a>
                            </li>
                            @endif 
                            @if(Auth::user()->inFuncionalidad('admonGeneral.diaFestivo'))
                            <li>
                                <a href="{{ url('/diasfestivos') }}"> Días Festivos</a>
                            </li>
                            @endif

                            @if(Auth::user()->inFuncionalidad('admonGeneral.denominacionmoneda'))
                            <li>
                                <a href="{{ url('/clientes/denominacionmoneda') }}">Denominación Moneda</a>
                            </li>
                            @endif
                             @if(Auth::user()->inFuncionalidades(['admonGeneral.sociedad.nombreCom','admonGeneral.sociedad.sociedad', 'admonGeneral.sociedad.zona', 'admonGeneral.sociedad.tienda', 'admonGeneral.sociedad.secueTienda']))
                            <li>
                                <a>Estructura de Negocio
                                    <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.sociedad.nombreCom'))
                                    <li>
                                        <a href="{{ url('/franquicia') }}">Nombre Comercial</a>
                                    </li>
                                    @endif 
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.sociedad.sociedad'))
                                    <li>
                                        <a href="{{ url('/sociedad') }}">Sociedades</a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.sociedad.zona'))
                                    <li>
                                        <a href="{{ url('/zona') }}">Zonas</a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.sociedad.tienda'))
                                    <li>
                                        <a href="{{ url('/tienda') }}">Tiendas</a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.sociedad.secueTienda'))
                                    <li>
                                        <a href="{{ url('/secuenciatienda') }}">Secuencias</a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.modificarClausulas')) 
                                    <li>
                                        <a href="{{ url ('/modificarClausulas') }}">Modificar Cláusulas</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif 
                            <!-- @if(Auth::user()->inFuncionalidades(['admonGeneral.estado.estado']))
                            <li>
                                <a> Maestro de Estados
                                    <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">                   
                                    @if(Auth::user()->inFuncionalidad('admonGeneral.estado.estado'))
                                    <li>
                                        <a href="{{ url('/gestionestado/estado') }}">Estados</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif -->
                        </ul>
                    </li>
                    @endif

                    @if(Auth::user()->inFuncionalidades(['gestionCliente.parametro.tipoTrabajo','gestionCliente.parametro.areaTrabajo','gestionCliente.parametro.tipoDocumento','gestionCliente.parametro.profesion', 'gestionCliente.parametro.calificacion', 'gestionCliente.parametro.pasaTiempo', 'gestionCliente.parametro.confiabilidad', 'gestionCliente.parametro.cargoEmpleado', 'gestionCliente.parametro.motivoRetiro','gestionCliente.parametro.eps', 'gestionCliente.parametro.cajaComp']))
                    <li>
                        <a> Parámetros de Clientes
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <!-- @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.tipoTrabajo'))
                            <li>
                                <a href="{{ url('/clientes/tipo/trabajo') }}">Tipo de Trabajo</a>
                            </li>
                            @endif -->
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.areaTrabajo'))
                            <li>
                                <a href="{{ url('/clientes/areatrabajo') }}">Áreas de Trabajo</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.tipoDocumento'))
                            <li>
                                <a href="{{ url('/clientes/tipodocumento') }}">Tipo de Documento</a>
                            </li>
                            {{--
                            <li>
                                <a href="{{ url('/clientes/tipodocumentodian') }}">Tipo de Documento Dian</a>
                            </li>--}}
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.profesion'))
                            <li>
                                <a href="{{ url('/clientes/profesion') }}">Profesiones</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.calificacion'))
                            <li>
                                <a href="{{ url('/calificacion') }}">Calificaciones</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.pasaTiempo'))
                            <li>
                                <a href="{{ url('/pasatiempo') }}">Pasatiempos</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.confiabilidad'))
                            <li>
                                <a href="{{ url('/clientes/confiabilidad') }}">Confiabilidad</a>
                            </li>
                            @endif
                            
                        </ul>
                    </li>
                    @endif

                    @if(Auth::user()->inFuncionalidades(['gestionProducto.asociarGeneral','gestionProducto.atributoProducto','gestionProducto.valorAtributo','gestionProducto.catalogoProducto']))
                    <li>
                        <a>
                            Parámetros de Productos
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if(Auth::user()->inFuncionalidad('gestionProducto.asociarGeneral'))
                            <li>
                                <a href="{{ url('/products/categories') }}">Categorías Generales</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('gestionProducto.atributoProducto'))
                            <li>
                                <a href="{{ url('/products/attributes') }}">Atributos</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('gestionProducto.valorAtributo'))
                            <li>
                                <a href="{{ url('/products/attributevalues') }}">Valores de Atributos</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('configContrato.configPrecio'))
                            <li>
                                <a href="{{ url('/products/references') }}">Catálogo de Productos</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('gestionProducto.catalogoProducto'))
                            <li>
                                <a href="{{ url('/configcontrato/valorventa') }}">Precios de Venta</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif 

                    @if(Auth::user()->inFuncionalidad(['configContrato.configGeneral','configContrato.configEspecifica','configContrato.configDiaGracia','configContrato.configRetroventa','configContrato.configContrato','configContrato.configPrecio']))
                    <li>
                        <a> Parámetros de Contratos
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if(Auth::user()->inFuncionalidad('configContrato.configGeneral'))
                            <li>
                                <a href="{{ url('/configcontrato/general') }}">Nivel General</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('configContrato.configEspecifica'))
                            <li>
                                <a href="{{ url('/configcontrato/especifica') }}">Nivel Específico</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('configContrato.configRetroventa'))
                            <li>
                                <a href="{{ url('/configcontrato/apliretroventa') }}">Aplicación de Retroventa</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('configContrato.configContrato'))
                            <li>
                                <a href="{{ url('/configcontrato/itemcontrato') }}">Configuración de Item</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('configContrato.configPrecio'))
                            <li>
                                <a href="{{ url('/configcontrato/valorsugerido') }}">Configuración de Precios de Contratación</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.planSepare'))
                    <li>
                        <a>
                            Parámetros Plan Separe
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ url('/gestionplan/config') }}">Nivel Específico</a>
                            </li>
                        </ul>
                    </li>
                    @endif 

                    @if(Auth::user()->inFuncionalidad('gestionContabilidad.plan1cuenta'))
                    <li>
                        <a>
                            Parámetros de Contabilidad
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ url('/clientes/planunicocuenta') }}">Plan Único de Cuentas</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif 
            @if(Auth::user()->inFuncionalidades(['gestionUser.usuario','gestionUser.rol','gestionUser.funcion']))
            <li>
                <a>
                    <i class="fa fa-users"></i> Gestión de Usuarios
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    @if(Auth::user()->inFuncionalidad('gestionUser.usuario'))
                    <li>
                        <a href="{{route('users')}}">Administrar Usuarios</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('gestionUser.rol'))
                    <li>
                        <a href="{{route('admin.roles')}}">Administrar Roles</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('gestionUser.funcion'))
                    <li>
                        <a href="{{route('admin.roles.module')}}">Asignar Módulo al Rol</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif 
            
            @if(Auth::user()->inFuncionalidades(['gestionCliente.cliente.personaNatural', 'gestionCliente.cliente.personaJuridica', 'gestionCliente.proveedor.personaNatural', 'gestionCliente.proveedor.personaJuridica']))
            <li>
                <a>
                    <i class="fa fa-cubes"></i> Gestión de Clientes/Proveedores
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                @if(Auth::user()->inFuncionalidades(['gestionCliente.cliente.personaNatural','gestionCliente.cliente.personaJuridica']))
                    <li>
                        <a> Clientes
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if(Auth::user()->inFuncionalidad('gestionCliente.cliente.personaNatural'))
                            <li>
                                <a href="{{ url('/clientes/persona/natural') }}">Cliente Natural</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.cliente.personaJuridica'))
                            <li>
                                <a href="{{ url('/clientes/persona/juridica') }}">Cliente Jurídico</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->inFuncionalidades(['gestionCliente.proveedor.personaNatural','gestionCliente.proveedor.personaJuridica']))
                    <li>
                        <a> Proveedores
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if(Auth::user()->inFuncionalidad('gestionCliente.proveedor.personaNatural'))
                            <li>
                                <a href="{{ url('/clientes/proveedor/persona/natural') }}">Proveedor Natural</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.proveedor.personaJuridica'))
                            <li>
                                <a href="{{ url('/clientes/proveedor/persona/juridica') }}">Proveedor Jurídico</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                </ul>
            </li>
            @endif @if(Auth::user()->inFuncionalidades(['gestionHumana.empleado','gestionHumana.reporte','gestionHumana.asociarTienda','gestionHumana.asociar.sociedad']))
            <li>
                <a>
                    <i class="fa fa-users"></i> Gestión Humana
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    @if(Auth::user()->inFuncionalidad('gestionHumana.empleado'))
                    <li>
                        <a href="{{ url('/clientes/empleado') }}">Gestión de Empleados</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('gestionHumana.empleado'))
                    {{-- <li>
                        <a href="{{ url('/clientes/empleadov2') }}">Gestión de Empleados V2</a>
                    </li> --}}
                    @endif @if(Auth::user()->inFuncionalidad('gestionHumana.reporte'))
                    <li>
                        <a href="{{ url('/gestionhumana/empleado/reporte') }}">Reportes de Empleados</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('gestionHumana.asociarTienda'))
                    <li>
                        <a href="{{ url('/asociarclientes/asociartienda') }}">Asociar a Tienda</a>
                    </li>
                    @endif 
                    <!-- @if(Auth::user()->inFuncionalidad('gestionHumana.asociar.sociedad'))
                    <li>
                        <a href="{{ url('/asociarclientes/asociarsociedad') }}">Asociar a Sociedad</a>
                    </li>
                    @endif -->
                    @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.cargoEmpleado'))
                            <li>
                                <a href="{{ url('/clientes/cargoempleado') }}">Cargo Empleado</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.motivoRetiro'))
                            <li>
                                <a href="{{ url('/clientes/motivoretiro') }}">Motivo Retiro</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.eps'))
                            <li>
                                <a href="{{ url('/clientes/eps') }}">Eps</a>
                            </li>
                            @endif
                            @if(Auth::user()->inFuncionalidad('gestionCliente.parametro.cajaComp'))
                            <li>
                                <a href="{{ url('/clientes/caja') }}">Caja de compensación</a>
                            </li>
                            @endif
                            
                </ul>
            </li>
            @endif 
			@if(Auth::user()->inFuncionalidades(['gestionarContrato','resolucionContrato','logistica','vitrina','maquilanacional','maquilaimportada']))
            <li>
                <a>
                    <i class="fa fa-file-text"></i> Gestión de Contratos
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    @if(Auth::user()->inFuncionalidad('gestionarContrato'))
                    <li>
                        <a href="{{ url('/contrato/index') }}">Gestión de Contratos</a>
                    </li>
					@endif @if(Auth::user()->inFuncionalidad('resolucionContrato'))
                    <li>
                        <a href="{{ url('/contratos/resolucionar') }}">Perfeccionamiento de Contratos Vencidos</a>
                    </li>
                    @endif 

                    @if(Auth::user()->inFuncionalidades(['logistica','vitrina','maquilanacional','maquilaimportada']))
                    <li>
                        <a>
                            Órdenes de Perfeccionamiento
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if(Auth::user()->inFuncionalidad('resolucionContrato'))
                            <li>
                                <a href="{{ url('/contrato/resolucion') }}">Perfeccionamiento de Contratos</a>
                            </li>
                            @endif 
                            @if(Auth::user()->inFuncionalidad('refaccion'))
                            <li>
                                <a href="{{ url('/contrato/prerefaccion') }}">Pre-refacción</a>
                            </li>
                            <li>
                                <a href="{{ url('/contrato/refaccion') }}">Refacción</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('fundicion'))
                            <li>
                                <a href="{{ url('/contrato/fundicion') }}">Fundición</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('logistica'))
                            <li>
                                <a href="{{ url('/contrato/logistica') }}">Logística</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('vitrina'))
                            <li>
                                <a href="{{ url('/contrato/vitrina') }}">Vitrina</a>
                            </li>
                            @endif @if(Auth::user()->inFuncionalidad('joyaespecial'))
                            <li>
                                <a href="{{ url('/contrato/joyaespecial') }}">Joya Especial</a>
                            </li>
                            @endif  @if(Auth::user()->inFuncionalidad('maquilanacional'))
                            <li>
                                <a href="{{ url('/contrato/maquila') }}">Maquila</a>
                            </li>
                            @endif   @if(Auth::user()->inFuncionalidad('maquilanacional'))
                            <li>
                                <a href="{{ url('/contrato/maquilanacional') }}">Maquila Nacional</a>
                            </li>
                            @endif  @if(Auth::user()->inFuncionalidad('maquilaimportada'))
                            <li>
                                <a href="{{ url('/contrato/maquilaimportada') }}">Maquila Importada</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                </ul>
            </li>
            @endif
            @if(Auth::user()->inFuncionalidad('gestionContabilidad.plan1cuenta'))
            <li>
                <a>
                    <i class="fa fa-calculator"></i> Gestión de Contabilidad
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    @if(Auth::user()->inFuncionalidad('tesoreria.tipodocumentocontable'))
                    <li>
                        <a href="{{ url('/tesoreria/tipodocumentocontable') }}">Tipo Documento Contable</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('tesoreria.arqueo'))
                    <li>
                        <a href="{{ url('/tesoreria/arqueo') }}">Arqueo</a>
                    </li>
                    @endif
                    @if(Auth::user()->inFuncionalidad('tesoreria.cierrecaja'))
                            <li>
                                <a href="{{ url('/tesoreria/cierrecaja') }}">Cierre de Caja</a>
                            </li>
                    @endif
                    @if(Auth::user()->inFuncionalidad('gestionContabilidad.configuracionContable'))
                            <li>
                                <a href="{{ url('/contabilidad/configuracioncontable') }}">Configuración Contable</a>
                            </li>
                    @endif
                    @if(Auth::user()->inFuncionalidad('gestionContabilidad.movimientosContables'))
                            <li>
                                <a href="{{ url('/contabilidad/movimientoscontables') }}">Movimientos Contables</a>
                            </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->inFuncionalidades(['tesoreria.impuesto','tesoreria.causacion']))
            <li>
                <a>
                    <i class="fa fa-calculator"></i> Gestión de Tesorería
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                     @if(Auth::user()->inFuncionalidad('tesoreria.impuesto'))
                    <li>
                        <a href="{{ url('/tesoreria/impuesto') }}">Impuestos</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('tesoreria.causacion'))
                    <li>
                        <a href="{{ url('/tesoreria/causacion') }}">Causacion</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('tesoreria.prestamos'))
                    <li>
                        <a href="{{ url('/tesoreria/prestamos') }}">Prestamos Entre Sociedades</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->inFuncionalidad('ReporteRotacion'))
            <li>
                <a>
                    <i class="fa fa-archive"></i> Pedidos
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    @if(Auth::user()->inFuncionalidad('ReporteRotacion'))
                    <li>
                        <a href="{{ url('/ReporteRotacion') }}">Reporte de rotación de inventario</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('pedidos'))
                    <li>
                        <a href="{{ url('/pedidos') }}">Pedidos</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('venta'))
                    <li>
                        <a href="{{ url('/ventas') }}">Ventas</a>
                    </li>
                    @endif @if(Auth::user()->inFuncionalidad('compra'))
                    <li>
                        <a href="{{ url('/compras') }}">Compras</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->inFuncionalidad('gestionPlanSeparare'))
            <li>
                <a>
                    <i class="fa fa-cubes"></i> Gestión Plan Separe
                    <span class="fa fa-chevron-down"></span>
                </a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{ url('/generarplan') }}">Generar Plan Separe</a>
                        </li>
                        <li>
                            <a href="{{ url('/cotizacion') }}">Cotizar plan separe</a>
                        </li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->inFuncionalidad('inventario'))
            <li>
                <a>
                    <i class="fa fa-cart-plus"></i> Gestión de Inventario
                    <span class="fa fa-chevron-down"></span>
                </a>
                    <ul class="nav child_menu">
                        @if(Auth::user()->inFuncionalidad('inventario'))
                        <li>
                            <a href="{{ url('/inventario') }}">Generar Inventario</a>
                        </li>
                        @endif @if(Auth::user()->inFuncionalidad('inventario.trazabilidad'))
                        <li>
                            <a href="{{ url('/inventario/trazabilidad') }}">Trazabilidad de los Ids</a>
                        </li>
                        @endif
                    </ul>
            </li>
            @endif
            @if(Auth::user()->inFuncionalidad('admonGeneral.abrirtienda'))            
            <li>
                <a href="{{ url('/tienda/abrir') }}">
                    <i class="fa fa-home"></i> Abrir Tienda
                    <span class=""></span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>