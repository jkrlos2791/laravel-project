<div id="modalPorcentaje" class="modal" tabindex="-1" role="dialog"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Porcentaje AFP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPorcentaje">
			<div class="col-md-12">
		          <input id="idPorcentaje" name="idPorcentaje" type="hidden" />	
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Tipo AFP * </label>
        			<div class="col-md-10">
        			    <select id="afp" name="afp" class="form-control" ></select>
        			</div>
        		  </div>		          
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Mes * </label>
        			<div class="col-md-4">
        			    <select id="mes" name="mes" class="form-control" ></select>
        			</div>
           		    <label class=" control-label col-md-2 text-left"> Anio * </label>
        			<div class="col-md-4">
        			    <select id="anio" name="anio" class="form-control" ></select>
        			</div>
        		  </div>
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-3 text-left"> Comision * </label>
        			<div class="col-md-3">
        			    <input id="comision" name="comision" type="text" class="form-control" ></input>  
        			</div>
           		    <label class=" control-label col-md-3 text-left"> Comision Mixta * </label>
        			<div class="col-md-3">
        			    <input id="comisionMixta" name="comisionMixta" type="text" class="form-control" ></input>  
        			</div>
        		  </div> 
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-3 text-left"> Fondo * </label>
        			<div class="col-md-3">
        			   	<input id="fondo" name="fondo" type="text" class="form-control" ></input>  
        			</div>
           		    <label class=" control-label col-md-3 text-left"> Seguro * </label>
        			<div class="col-md-3">
        			  	<input id="seguro" name="seguro" type="text" class="form-control" ></input>  
        			</div>
        		  </div> 
        		   <div class="form-group row " >
        		    <label class=" control-label col-md-3 text-left"> Tope * </label>
        			<div class="col-md-3">
        			   	<input id="tope" name="tope" type="text" class="form-control" ></input>  
        			</div>
           		    <label class=" control-label col-md-3 text-left"> Importe Tope * </label>
        			<div class="col-md-3">
        			   	<input id="importeTope" name="importeTope" type="text" class="form-control" ></input>  
        			</div>
        		  </div> 
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button id="guardarPorcentaje" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        <button id="cerrarPorcentaje" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>