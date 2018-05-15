<?php
require_once "utilidades.php";
class getV_rs extends utilidades{
    public function __construct(){

    }
    public function getTableViewAll($val): String{
        $id = "IdentificadorDeLaTabla";
        $script = "".$this->getTablaScript($id,"");
        $thead = $this->thead(array('Nombre','Correo','Acciones'), $id);
        $tbody = $this->getDataTable($val, $id);
        return $this->table($script, $id, $thead, $tbody);
        
    }
    public function getTableViewAllActividades($val): String{
        $id = "IdentificadorDeLaTablaDos";
        $script = $this->getTablaScript($id,',"order": [[ 1, "desc" ]]');
        $thead = $this->thead(array('Descripcion','Hora y Fecha','Lugar','Estado',''), $id);
        $tbody = $this->getDataTableActi($val, $id);
        return $this->table($script, $id, $thead, $tbody);
        
    }
    public function getFormResultConsulta($val,$id): String{
        return $this->getFormRegistroGeneric($val,1,array(),$id);
    }
    function getFormRegistroGeneric($data, $NivelDeAcceso,$dataExternal,$id){
            $id_actividad = "<input type='hidden' value='$id' name='id_actividad' id='id_actividad' />";
            $title = "";
            $status = $data[0]['IStatus_actividad'];
            $star = 1;
            if($status == 1){
                $title = 'Enviar';
            }else if($status === 4){
                $title = 'Actualizar';
            }else{
                $star = 2;
            }$action="";
            if($NivelDeAcceso==1){$action="enviar";}else{$action="actualizar";}
            $title.=" Actividad";
            $nval =<<<EOT
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title panel-primary" id="myModalLabel">$title</h4>
                  </div>
                  <form action='#!' class="form-horizontal"
                      id='registro_actualiza_actividad' role="form"
                          data-toggle="validator" enctype="multipart/form-data">
                    <script src="vista/js/herr/form_rs/form_rs_rs_actividad.js"></script>
                        <div class="modal-body">
                            $id_actividad
                            <input type='hidden' value='$action' name='action' id='action' />
                             <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="lugar">Foto 1</label>  
                                <div class="col-md-7">
                                <input type="file" id="foto1" name="foto1" class="form-control-file" accept="image/jpg" data-validation="required">
                                <span class="help-block"></span>  
                                </div>
                              </div>
                                <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="lugar">Foto 2</label>  
                                <div class="col-md-7">
                                <input type="file" id="foto2" name="foto2" class="form-control-file" accept="image/jpg" data-validation="required">
                                <span class="help-block"></span>  
                                </div>
                              </div>
                                <div class="form-group">
                                 <label class="col-md-4 control-label" for="op">$title</label>
                                  <div class="col-md-7">
                                     <button id="op" name="op" class="btn btn-primary">$title</button>
                                  </div>
                                 </div>
                                </div>
                        </div>
                  </form>
                </div>
              </div>
            </div>
EOT;
                return $nval;
        }
    public function getDataTableActi($data,$id): String{
        $tableTr = "";
        foreach ($data as $row) {
            $btn = "";
            if($row['id_actividad_ss']==1){
                $btn = <<<EOT
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" 
                            onclick="menuD.get_actividad_id({$row['id_actividad']});"
                            title="Enviar Avance!">                          
                            <span class="glyphicon glyphicon-modal-window">
                            </span>
                        </a>
EOT;
            }else if($row['id_actividad_ss']==2 || $row['id_actividad_ss']==4){
                $btn = <<<EOT
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" 
                            onclick="menuD.get_actividad_id_rev({$row['id_actividad']});"
                            title="Informacion!">                          
                            <span class="glyphicon glyphicon-lamp">
                            </span>
                        </a>
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" 
                            onclick="menuD.get_actividad_id({$row['id_actividad']});"
                            title="Actualizar Avance!">                          
                            <span class="glyphicon glyphicon-modal-window">
                            </span>
                        </a>
EOT;
            }else if($row['id_actividad_ss']==3){
                $btn = <<<EOT
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" 
                            onclick="menuD.get_actividad_id_rev({$row['id_actividad']});"
                            title="Informacion!">                          
                            <span class="glyphicon glyphicon-lamp">
                            </span>
                        </a>
EOT;
            }
            $tableTr = <<<EOT
              <tr>
                    <td>
                        {$row['Vdescripcion_actividad']}
                    </td>
                    <td>
                        {$row['Dhorayfecha_actividad']}
                    </td>
                    <td>
                        {$row['VLugar_Direccion']}
                    </td>
                    <td>
                        {$row['nombre_actividad']}
                    </td>
                    <td>
                        $btn
                    </td>
              </tr>
EOT;
        }
        return $tableTr;
    }
    public function getDataTable($data,$id): String{
        $tableTr = "";
        foreach ($data as $row) {
            $tableTr.= <<<EOT
              <tr>
                    <td>
                        {$row['firstname']} <br> {$row['lastname']}
                    </td>
                    <td>
                        {$row['user_email']}
                    </td>
                    <td>
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" 
                            onclick="menuD.get_actividades({$row['id_user_user']});"
                            title="Ver las Actividades!">
                            Ver Las actividades 
                            <span class="glyphicon glyphicon-modal-window">
                            </span>
                        </a>
                    </td>
              </tr>
EOT;
        }
        return $tableTr;
    }
}