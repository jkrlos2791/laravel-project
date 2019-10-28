<div id="modalFormModulo" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Nuevo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="formModulo" enctype="multipart/form-data">
			<div class="col-md-12">
        		  <div class="form-group row " >
                    <label class=" control-label col-md-2 text-left"> Nombre </label>
        			<div class="col-md-10">
    			        <input id="nombre" name="nombre" type="text" />
        			 </div>   
        		  </div> 					
			</div>
    		<div class="col-md-12">
        		  <div class="form-group row " >
                    <label class=" control-label col-md-2 text-left"> Archivo (.xlsx) </label>
        			<div class="col-md-10">
                        {!! Form::file('import_file') !!}
        			 </div>   
        		  </div> 					
    		</div>
		</form>
      </div>
		<div class="modal-footer">
			<button id="guardarModulo" type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Guardar</button>
			<button id="cerrarModulo" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>