<div id="modalServicio" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formServicio">
			<div class="col-md-12">
		          <input id="idServicio" name="idServicio" type="hidden" />
		          <input id="facturas" name="facturas" type="hidden" />
		          <input id="guias" name="guias" type="hidden" />
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Nro. Servicio </label>
        			<div class="col-md-4">
        			    <input id="nroServicio" name="nroServicio" type="text" class="form-control" ></input>  
        			</div>
        			<label class=" control-label col-md-2 text-left"> Fecha </label>
        			<div class="col-md-4">
        			    <input id="fecha" name="fecha" type="text"  class="form-control" ></input>  
        			</div> 
        		  </div> 					
        		  <div class="form-group row " >
        			<label class=" control-label col-md-2 text-left"> Cliente </label>
        			<div class="col-md-4">
        			  <select id="cliente" name="cliente" class="element-select" ></select> 
        			 </div>
        			<label class=" control-label col-md-2 text-left"> Vehículo </label>
        			<div class="col-md-4">
        			  <select id="vehiculo" name="vehiculo" class="element-select" ></select> 
        			 </div> 
        		  </div> 					
        		  <div class="form-group row " >
        			<label class=" control-label col-md-2 text-left"> Conductor </label>
        			<div class="col-md-4">
        			  <select id="chofer" name="chofer" class="element-select" ></select> 
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Estibador </label>
        			<div class="col-md-4">
        			  <select id="estibador" name="estibador" class="element-select" ></select> 
        			</div>
        		  </div> 					
        		  <div class="form-group row " >
        			<label class=" control-label col-md-2 text-left"> Km Inicial </label>
        			<div class="col-md-4">
        			    <input id="kmInicial" name="kmInicial" type="text" class="form-control" ></input>  
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Km Final </label>
        			<div class="col-md-4">
        			    <input id="kmFinal" name="kmFinal" type="text" class="form-control" ></input>  
        			 </div>
        		  </div> 					
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Tipo </label>
        			<div class="col-md-4">
        			    <select id="tipoServicio" name="tipoServicio" class="form-control" >
        			        <option value="">Seleccione...</option>
        			        <option value="Transporte">Transporte</option>
        			        <option value="Courier">Courier</option>
        			        <option value="Tercerizado">Tercerizado</option>
        			    </select>  
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Estado </label>
        			<div class="col-md-4">
        			    <select id="estado" name="estado" class="form-control" >
        			        <option value="">Seleccione...</option>
        			        <option value="Pendiente">Pendiente</option>
        			        <option value="Finalizado">Finalizado</option>
        			    </select> 
        			</div> 
        		  </div>
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Subtotal </label>
        			<div class="col-md-4">
                        <input id="subtotal" name="subtotal" type="text" class="form-control" onkeyup="calcularTotal()" ></input> 
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Total </label>
        			<div class="col-md-4">
        			    <input id="total" name="total" type="text" class="form-control" disabled></input>
        			</div> 
        		  </div>
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Costo Prov. </label>
        			<div class="col-md-4">
                        <input id="costoProv" name="costoProv" type="text" class="form-control"></input> 
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Fatura Prov. </label>
        			<div class="col-md-4">
        			    <input id="facturaProv" name="facturaProv" type="text" class="form-control"></input>
        			</div> 
        		  </div>
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Factura </label>
        			<div class="col-md-4">
        			    <div class="input-group mb-3">
                            <input id="factura" name="factura" type="text" class="form-control" ></input>
                            <div class="input-group-append">
                                <button id="agregarFactura" class="btn btn-outline-secondary" type="button"><i class="fas fa-search-plus"></i></button>
                            </div>
                        </div>
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Guias </label>
        			<div class="col-md-4">
        			    <div class="input-group mb-3">
            			    <input id="guia" name="guia" type="text" class="form-control" ></input>
            			    <div class="input-group-append">
                                <button id="agregarGuia" class="btn btn-outline-secondary" type="button"><i class="fas fa-search-plus"></i></button>
                            </div>
                        </div>
        			</div> 
        		  </div>
        		  <div class="form-group row " >
                        <div class="col-md-6">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="tablaFactura">
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="tablaGuia">
                                <tfoot></tfoot>
                            </table>
                        </div>
        		  </div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button id="guardarServicio" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        <button id="cerrarServicio" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>