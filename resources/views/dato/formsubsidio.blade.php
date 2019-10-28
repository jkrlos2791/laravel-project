<div id="modalSubsidio" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Subsidio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formSubsidio">
			<div class="col-md-12">
		          <input id="idSubsidio" name="idSubsidio" type="hidden" />		          
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Tipo </label>
        			<div class="col-md-10">
        			    <select id="tipoSubsidio" name="tipoSubsidio" class="form-control" onchange="hacerSegunTipo()"></select>
        			</div>
        		  </div> 																			
        		  <div class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Fecha Inicio </label>
        			<div class="col-md-4">
                        <input id="inicioSubsidio" name="inicioSubsidio" type="text" class="form-control" ></input>  
        			 </div> 
        			<label class=" control-label col-md-2 text-left"> Fecha Fin </label>
        			<div class="col-md-4">
        			    <input id="finSubsidio" name="finSubsidio" type="text" class="form-control" ></input>  
        			</div> 
        		  </div>
        		  <div id="groupNroSubsidio" class="form-group row " >
        		    <label class=" control-label col-md-2 text-left"> Nro. de Subsidio </label>
        			<div class="col-md-10">
                        <input id="nroSubsidio" name="nroSubsidio" type="text" class="form-control" ></input>  
        			 </div> 
        		  </div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button id="guardarSubsidio" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        <button id="cerrarSubsidio" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>