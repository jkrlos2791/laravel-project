<div id="modalSearchEmpresa" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Buscar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="formSearchEmpresa">
			<div class="col-md-12">
        		  <div class="form-group row " >
                    <label class=" control-label col-md-2 text-left"> Empresa </label>
        			<div class="col-md-10">
        			    <select id="empresa" name="empresa" class="empresa-select" >
        			    </select>  
        			 </div>   
        		  </div> 					
			</div>
      </div>
		</form>
		<div class="modal-footer">
			<button id="verEmpresa" type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
			<button id="cerrar" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>