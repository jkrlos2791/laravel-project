<div id="exportPlanilla" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Planilla</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('url'=>'exportarPlanilla', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
			<div class="col-md-12">
        		  <div class="form-group row " >
                    <label class=" control-label col-md-4 text-left"> Centro de costo </label>
        			<div class="col-md-8">
        			    <select id="centroCosto" name="centroCosto" class="form-control" ></select>  
        			 </div>   
        		  </div> 					
        		  <div class="form-group row " >
        			<label class=" control-label col-md-4 text-left"> Régimen pensionario </label>
        			<div class="col-md-8">
        			    <select id="regimenPen" name="regimenPen" class="form-control" ></select> 
        			</div> 
        		  </div>
			</div>
      </div>
      <div class="modal-footer">
        <button id="exportPLanilla2" type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</button>
        <button id="cerrar" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>