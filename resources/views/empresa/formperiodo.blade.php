<div id="modalPeriodo" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Periodo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPeriodo">
			<div class="col-md-12">
		          <input id="idPeriodo" name="idPeriodo" type="hidden" />		          
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-1 text-left"> Mes </label>
        			<div class="col-md-5">
        			    <select id="mes" name="mes" class="form-control" ></select>
        			</div>
           		    <label class=" control-label col-md-1 text-left"> Anio </label>
        			<div class="col-md-5">
        			    <select id="anio" name="anio" class="form-control" ></select>
        			</div>
        		  </div> 					
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button id="guardarPeriodo" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        <button id="cerrarPeriodo" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>