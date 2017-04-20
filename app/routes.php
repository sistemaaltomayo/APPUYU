<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
 /***************************************  Authentication ******************************************/

 	Route::any('/', 'AutentificacionController@actionLogin');
 	Route::any('/login', 'AutentificacionController@actionLogin');
 	Route::get('/cerrarsesion', 'AutentificacionController@actionCerrarSesion');
 	Route::any('/bienvenidos-coffee-and-arts', 'AutentificacionController@actionBienvenidoCoffeeAndArts');


 	Route::any('/getion-permisos/{idOpcion}', 'AutentificacionController@actionListarPermisos');
 	Route::any('/listar-ajax-permisos', 'AutentificacionController@actionListarAjaxPermisos');
 	Route::any('/activar-ajax-permisos', 'AutentificacionController@actionActivarAjaxPermisos');
 	Route::any('/listar-ajax-permisos-plus', 'AutentificacionController@actionListarAjaxPermisosPlus');
	Route::any('/activar-ajax-permisos-plus', 'AutentificacionController@actionActivarAjaxPermisosPlus');

 /***************************************  TOMA PEDIDO ******************************************/

 	Route::any('/getion-toma-pedido/{idOpcion}', 'TomaPedidoController@actionTomaPedido');
	Route::any('/listaproductoajax', 'TomaPedidoController@actionlistaProductoAjax');
	Route::any('/cartajax', 'TomaPedidoController@actionCartAjax');
	Route::any('/productodetajax', 'TomaPedidoController@actionProductoDetAjax');
	Route::any('/actualizarruc', 'TomaPedidoController@actionActualizarRuc');
	Route::any('/mostrarnotaajax', 'TomaPedidoController@actionMostrarNotaAjax');
	Route::any('/eliminarproductoajax', 'TomaPedidoController@actionEliminarProductoAjax');
	Route::any('/insertarconajax', 'TomaPedidoController@actionInsertarConAjax');
	Route::any('/getion-toma-cocina/{idOpcion}', 'TomaPedidoController@actionCocina');
	Route::any('/cocinaajax', 'TomaPedidoController@actionCocinaAjax');
	Route::any('/atendido', 'TomaPedidoController@actionAtendido');
	Route::any('/getion-toma-pedido-listos/{idOpcion}', 'TomaPedidoController@actionCocinaMesero');


 /***************************************  ENCUESTAS ******************************************/

 	Route::any('/getion-encuesta/{idOpcion}', 'EncuestaController@actionEncuesta');
 	Route::any('/agregar-encuesta/{idOpcion}', 'EncuestaController@actionAgregarEncuesta');
	Route::any('/insertarencuesta', 'EncuestaController@actionInsertarEncuesta');
	Route::any('/atencione/{idOpcion}', 'EncuestaController@actionAtencionE');

 	Route::any('/getion-eventos-promociones/{idOpcion}', 'EncuestaController@actionPromocionesEventos');
 	Route::any('/agregar-promociones-eventos/{idOpcion}', 'EncuestaController@actionAgregarPromocionesEventos');
 	Route::any('/registrarcliente/{idOpcion}', 'EncuestaController@actionRegistrarCliente');

 	Route::any('/getion-check-list/{idOpcion}', 'InspeccionController@actionCheckList');
 	Route::any('/agregar-checklist/{idOpcion}', 'InspeccionController@actionAgregarCheckList');
	Route::any('/detallechecklist/{idlocalinspeccion}/{codigo}/{idOpcion}', 'InspeccionController@actionDetalleCheckList');
 	Route::any('/ajaxagregarchecklist', 'InspeccionController@actionajaxAgregarCheckList');
 	Route::any('/ajaxlistarchecklist/{idOpcion}', 'InspeccionController@actionajaxListarCheckList');


/*****************************************************************************************************/ 
/***************************************  Inventario ******************************************/


			/***************************************  CAFETERIA ******************************************/

	Route::any('/getion-inventario-cafeteria/{idOpcion}', 'InventarioController@actionListaTomaInventario');
	Route::any('/insertar-toma-inventario/{idOpcion}', 'InventarioController@actionInsertarTomaInventario');
	Route::any('/editar-toma-inventario/{idOpcion}/{idtomaweb}', 'InventarioController@actionEditarTomaInventario');
	Route::any('/actualizar-toma-inventario/{idOpcion}', 'InventarioController@actionActualizarTomaInventario');
	Route::any('/toma-inventario-cafeteria/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionTomaDeInventario');
	Route::any('/insertar-stock-inventario', 'InventarioController@actionInsertarStockInventario');
	Route::any('/agregar-usuarios-cafeteria/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionAgregarUsuarioTomaInventario');
	Route::any('/insertar-usuario-toma-inventario', 'InventarioController@actionInsertarUsuarioTomaInventario');
	Route::any('/usuarios-exitoso/{idOpcion}', 'InventarioController@actionUsuariosExitoso');
	Route::any('/monitoreo-inventario-cafeteria/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionMonitoreoDeInventario');
	Route::any('/descargar-excel-inventario-cafeteria/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionReporteInventario');
	Route::any('/primer-cierre-inventario-cafeteria/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionPrimerCierreInventario');
	Route::any('/segundo-cierre-inventario-cafeteria/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionSegundoCierreInventario');
	Route::any('/cerrar-toma-otro-usuario/{idtomaweb}/{idOpcion}', 'InventarioController@actionCerrarTomaOtroUsuario');

	
			/***************************************  MARKET ******************************************/
			

	Route::any('/getion-inventario-market/{idOpcion}', 'InventarioController@actionListaTomaInventarioA');
	Route::any('/insertar-toma-inventario-artesania/{idOpcion}', 'InventarioController@actionInsertarTomaInventarioA');
	Route::any('/editar-toma-inventario-market/{idOpcion}/{idtomaweb}', 'InventarioController@actionEditarTomaInventarioA');
	Route::any('/actualizar-toma-inventario-artesania/{idOpcion}', 'InventarioController@actionActualizarTomaInventarioA');
	Route::any('/toma-inventario-market/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionTomaDeInventarioA');
	Route::any('/insertar-stock-inventario-artesania', 'InventarioController@actionInsertarStockInventarioA');
	Route::any('/agregar-usuarios-market/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionAgregarUsuarioTomaInventarioA');
	Route::any('/insertar-usuario-toma-inventario-artesania', 'InventarioController@actionInsertarUsuarioTomaInventarioA');
	Route::any('/usuarios-exitoso-artesania/{idOpcion}', 'InventarioController@actionUsuariosExitosoA');
	Route::any('/monitoreo-inventario-market/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionMonitoreoDeInventarioA');
	Route::any('/descargar-excel-inventario-market/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionReporteInventarioA');
	Route::any('/primer-cierre-inventario-market/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionPrimerCierreInventarioA');
	Route::any('/segundo-cierre-inventario-market/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionSegundoCierreInventarioA');
	Route::any('/cerrar-toma-otro-usuario-artesania/{idtomaweb}/{idOpcion}', 'InventarioController@actionCerrarTomaOtroUsuarioA');


			/***************************************  EMBARQUE ******************************************/


	Route::any('/getion-inventario-embarque/{idOpcion}', 'InventarioController@actionListaTomaInventarioE');
	Route::any('/insertar-toma-inventario-embarque/{idOpcion}', 'InventarioController@actionInsertarTomaInventarioE');
	Route::any('/editar-toma-inventario-embarque/{idOpcion}/{idtomaweb}', 'InventarioController@actionEditarTomaInventarioE');
	Route::any('/actualizar-toma-inventario-embarque/{idOpcion}', 'InventarioController@actionActualizarTomaInventarioE');
	Route::any('/toma-inventario-embarque/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionTomaDeInventarioE');
	Route::any('/insertar-stock-inventario-embarque', 'InventarioController@actionInsertarStockInventarioE');
	Route::any('/agregar-usuarios-embarque/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionAgregarUsuarioTomaInventarioE');
	Route::any('/insertar-usuario-toma-inventario-embarque', 'InventarioController@actionInsertarUsuarioTomaInventarioE');
	Route::any('/usuarios-exitoso-embarque/{idOpcion}', 'InventarioController@actionUsuariosExitosoE');
	Route::any('/monitoreo-inventario-embarque/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionMonitoreoDeInventarioE');
	Route::any('/descargar-excel-inventario-embarque/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionReporteInventarioE');
	Route::any('/primer-cierre-inventario-embarque/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionPrimerCierreInventarioE');
	Route::any('/segundo-cierre-inventario-embarque/{idOpcionPLus}/{idtomaweb}/{idOpcion}', 'InventarioController@actionSegundoCierreInventarioE');
	Route::any('/cerrar-toma-otro-usuario-embarque/{idtomaweb}/{idOpcion}', 'InventarioController@actionCerrarTomaOtroUsuarioE');


	Route::any('/unidaddestinoajax', 'InventarioController@actionUnidadDestinoAjax');
	Route::any('/convertir-unidad', 'InventarioController@actionConvertirUnidad');




/*****************************************************************************************************/ 
/***************************************  PERSONAL ******************************************/

			/***************************************  solicitud ******************************************/
	Route::any('/getion-solicitud-personal/{idOpcion}', 'PersonalController@actionListaSolicitudPersonal');
	Route::any('/insertar-solicitud-personal/{idOpcion}', 'PersonalController@actionInsertarSolicitudPersonal');
	Route::any('/modificar-solicitud-personal/{idOpcion}/{idSolicitud}', 'PersonalController@actionModificarSolicitudPersonal');
	Route::any('/agregar-personal-solicitud/{idOpcionPlus}/{idSolicitud}', 'PersonalController@actionAgregarPersonalSolicitud');
	Route::any('/agregar-personal-termino-solicitud-ajax', 'PersonalController@actionAgregarPersonalTerminoSolicitudAjax');


 /***************************************  AJAX ******************************************/


	Route::any('/ajax-select-distrito', 'GeneralAjaxController@actiondistritoajax');

/*****************************************************************************************************/

	App::missing(function($exception){
				return View::make('error.error404',
						 ['active'  => 'activereclamaciones',
						  'dato'    => 'reclamaciones',
						  'container'    => 'containerreclamaciones',
						  'fondoo'    => 'fondoreclamaciones'
						 ]);
	});





