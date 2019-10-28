<div id="modalIngresoEmpresa" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Ingresar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="formIngresoEmpresa">
			<div class="col-md-12">
        		  <div class="form-group row " >
                    <label class=" control-label col-md-2 text-left"> Empresa </label>
        			<div class="col-md-10">
        			    <select id="inicioEmpresa" name="inicioEmpresa" class="inicio-empresa-select" onchange="cargarComboPeriodos()">
        			    </select>  
        			 </div>   
        		  </div>
        		  <div id="groupPeriodo" class="form-group row " >
                    <label class=" control-label col-md-2 text-left"> Periodo </label>
        			<div class="col-md-10">
        			    <select id="inicioPeriodo" name="inicioPeriodo" class="inicio-periodo-select" >
        			    </select>  
        			 </div>   
        		  </div> 
			</div>
      </div>
		</form>
		<div class="modal-footer">
			<button id="ingresarEmpresa" type="submit" class="btn btn-success"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
			<button id="cerrar" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>