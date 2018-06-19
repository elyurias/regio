<?php
    require_once "utilidades.php";
    class getV_rd extends utilidades{
        public function __construct(){

        }
        function getTableRs($data){
            $d = "";
            $i = 0;
            foreach($data as $row){
                $ncad = substr($row['date_added'],0,10);
                $d.= <<<EOT
                <tr>
                    <td>
                        {$row['firstname']} <br>
                        {$row['lastname']} 
                    </td>
                    <td>
                        {$row['user_name']}
                    </td>
                    <td>
                        {$row['user_email']}
                    </td>
                    <td>
                        {$ncad}
                    </td>
                    <td>
                        <a class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                            onclick="menuC.get_all_actividades({$row['id_user_user']},'{$row['firstname']} {$row['lastname']}');"
                            title="Ver sus Actividades!">
                            <span class="glyphicon glyphicon-search">
                            </span>
                        </a>
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" 
                            onclick="menuC.get_formulario_actividad({$row['id_user_user']});"
                            title="Programar Nueva Actividad!">
                            <span class="glyphicon glyphicon-modal-window">
                            </span>
                        </a>
                    </td>
                </tr>
EOT;
                        $i = $i + 1;
            }
            return $this->getTableComponent($d);
        }
        public function getTableComponent($data){
            $varC = <<<EOT
            <script>
                $(()=>{
                    $('[data-toggle="tooltip"]').tooltip();
                    var table = $('#tablePrincipal2').DataTable({
                        "language": {
                            "url": "vista/js/json/lenguaje.json"
                        },
                        responsive: true
                    });
                    new $.fn.dataTable.FixedHeader( table );
                })
            </script>
		<div class="panel-body">
            <table id="tablePrincipal2" class="table table-striped table-bordered nowrap" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th data-priority="1">
                            Full Name
                        </th>
                        <th data-priority="2">
                            Username
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    $data
                </tbody>
            </table>
        </div>
    </div>    
EOT;
            return $varC;
        }
        function getFormRegistroGeneric($data, $NivelDeAcceso,$dataExternal,$id){
            $variableObsoleta = "";
            switch ($NivelDeAcceso){
                case 1:
                    $variableObsoleta = "";
                break;
                case 2:
                    $variableObsoleta = "<input type='hidden' value='_ID_ACTIVIDAD_' name='id_actividad' id='id_actividad' />";
                break;
            }
            $title = $NivelDeAcceso = 1? 'Registrar Actividad':'Actualizar Actividad';
            $nval =<<<EOT
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title panel-primary" id="myModalLabel">$title</h4>
                  </div>
                  <form action='#!' class="form-horizontal" id='registro_actualiza_actividad' role="form" data-toggle="validator" onsubmit="return false;">
                  <script src="vista/js/herr/form_rs/form.js"></script>
                  <div class="modal-body">
                  <fieldset>
                  <input type="hidden" value="$NivelDeAcceso" name="action" id="action" />
                  $variableObsoleta
                  
                  <!-- TextArea input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="paterno">Descripcion de la actividad</label>  
                    <div class="col-md-7">
                        <textarea name="descripcion" class="form-control input-md" data-validation="required"></textarea>
                    <span class="help-block"></span>  
                    </div>
                  </div>
                  
                  <!-- Date input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="fecha">Fecha de entrega</label>  
                    <div class="col-md-7">
                    <input id="fecha" name="fecha" type="text" class="form-control input-md" autocomplete="off" data-validation="required">
                    <span class="help-block"></span>  
                    </div>
                  </div>
                  <script>
                    jQuery('#fecha').datetimepicker();
                  </script>
                  <input type="hidden" value="$id" name="id_user_user" id="id_user_user" />
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="lugar">Lugar</label>  
                    <div class="col-md-7">
                    <input id="lugar" name="lugar" placeholder="Lugar donde se realizo" class="form-control input-md" data-validation="required">
                    <span class="help-block"></span>  
                    </div>
                  </div>
                    <div class="modal-footer">
                  <!-- Button -->
                    <div class="form-group">
                     <label class="col-md-4 control-label" for="op">$title</label>
                      <div class="col-md-7">
                         <button id="op" name="op" class="btn btn-primary" onclick="menuC.insertActividad();">$title</button>
                      </div>
                     </div>
                    </div>
                  </fieldset>
                  </form>
                </div>
              </div>
            </div>
EOT;
                return $nval;
        }
        
        
        public function get_All_data_cc($data,$userName){
            $d = "";
            $i = 0;
            $limiteDeCadena = 12;
            foreach($data as $row){
                $limite = $limiteDeCadena;
                $procesaDescripcion = $this->get_cadena_vista($limite, $limiteDeCadena, $row['Vdescripcion_actividad']);
                $procesaLugar = $this->get_cadena_vista($limite, $limiteDeCadena, $row['VLugar_Direccion']);
                $ncad = substr($row['Dhorayfecha_actividad'],0,10);
                
                $status = $this->get_cadena_vista($limite, $limiteDeCadena, $row['nombre_actividad']);
                $btn_btn_status = $row['id_actividad_ss']==2? <<<EOT
                        <a class="btn btn-primary" onclick="menuC.leer_actividad({$row['id_actividad']});" data-toggle="tooltip" data-placement="top" title="Revisar!"><span class="glyphicon glyphicon-eye-open"></span></a>
EOT
                :"";
                $d.= <<<EOT
                <tr id="componente_slash{$row['id_actividad']}">
                    <td>
                        $procesaDescripcion
                    </td>
                    <td>
                        $procesaLugar
                    </td>
                    <td>
                        {$ncad}
                    </td>
                    <td>
                        {$status}
                    </td>
                    <td>
                        <a class="btn btn-danger" onclick="menuC.delete_actividad({$row['id_actividad']});" data-toggle="tooltip" data-placement="top" title="Eliminar!"><span class="glyphicon glyphicon-remove"></span></a>
                        $btn_btn_status
                    </td>
                </tr>
EOT;
                        $i = $i + 1;
            }
            return $this->getModalActividades($this->cont_data_table($d),$userName);
        }
        function cont_data_table($data){
            return <<<EOT
            <table id="tablePrincipal" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                          <tr>
                                <th>
                                    Descripcion
                                </th>
                                <th>
                                    Lugar
                                </th>
                                <th>
                                    Fecha
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>
                                    
                                </th>
                          </tr>
                        </thead>
                        <tbody>
                            $data
                        </tbody>
                     </table>
EOT;
        }
        function getModalActividades($data,$userName){
            $variab = $this->getTablaScript('tablePrincipal',',"order": [[ 2, "desc" ]]');
            $nval =<<<EOT
            <!-- Modal -->
            $variab
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title panel-primary" id="myModalLabel">Actividades registradas del usuario $userName</h4>
                  </div> 
                  <div class="modal-body">
                    $data
                  </div>
                </div>
              </div>
            </div>
EOT;
                return $nval;
        }
    }
