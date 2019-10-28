<div id="modalCentroCosto" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Centro de Costo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCentroCosto">
			<div class="col-md-12">
		          <input id="idCentroCosto" name="idCentroCosto" type="hidden" />		          
        		  <div class="form-group row " >
        			<label class=" control-label col-md-2 text-left"> Descripción </label>
        			<div class="col-md-4">
        			  <input id="centroCosto" name="centroCosto" type="text" class="form-control" ></input>  
        			 </div>
        		  </div> 														
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button id="guardarCentroCosto" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        <button id="cerrarCentroCosto" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>