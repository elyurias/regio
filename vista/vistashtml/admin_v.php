<?php
    class getV_administrator{
        public function __construct(){

        }
        function convertir_UTF8($_STR){
            //return utf8_decode($_STR);
            return $_STR;
        }
        public function getSelectCarrera($data,$titleID){
            $title = $titleID == 2 ? 'RD' : 'RS';
            $str = "
            <div class='form-inline btn-grid'>
                        <label for='carrera'>Selecciona la carrera:</label>
                            <select class='form-control' name='carrera' id='carrera' onchange='menuA.getEventLineOperation();'>
                                <option value='0'>Seleccione una Opcion</option>
                    ";
            foreach ($data as $value)
            $str.=<<<EOT
                                <option value="{$value['id_especialidad']}">
                                    {$this->convertir_UTF8($value['Vnombre_especialidad'])}
                                </option>
EOT;
            $str.="</select>
            <button type='button' class='btn btn-success' onclick='menuA.generateForm($titleID)' ><span class='glyphicon glyphicon-plus'></span> Agregar $title</button>
            </div>
            ";
            $contenedor = "
            <div class='panel-heading'>
		        <div class='btn-group'>                   
                    $str 
                </div>
		    </div>
            ";
            return $contenedor;
        }
        public function get_All_data_cc($data,$typeOF){
            $d = "";
            $i = 0;
            foreach($data as $row){
                $ncad = substr($row['date_added'],0,10);
                $status = $row['status']==1 ? 'Activo' : 'Inactivo';
                $gligli = $row['status']==1 ? 'glyphicon-eye-open' : 'glyphicon-eye-close';
                $color = $row['status']==1 ? 'btn-success' : 'btn-danger';
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
                        <a class="btn btn-danger" onclick="menuA.delete_user({$row['user_id']});" data-toggle="tooltip" data-placement="top" title="Eliminar!"><span class="glyphicon glyphicon-remove"></span></a>
                        <!-- <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modificar!"><span class="glyphicon glyphicon-modal-window"></span></a>
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Leer!"><span class="glyphicon glyphicon-search"></span></a>
                        --><input type='hidden' value='{$row['status']}' id='_val_status{$i}'>
                        <script>
                            val_status{$i} = {$row['status']};
                        </script>
                        <a class="btn $color" onclick="menuA.isEnabledUser({$i},val_status{$i},'nval{$i}',{$row['user_id']});" id="nval{$i}" data-toggle="tooltip" data-placement="top" title="{$status}!"><span class="glyphicon $gligli" id="nval{$i}2"></span></a>
                    </td>
                </tr>
EOT;
                        $i = $i + 1;
            }
            return $this->getTableComponent($typeOF,$d,$typeOF);
        }
        public function getTableComponent($title,$data,$titleID){
            $varC = <<<EOT
            <script>
                $(()=>{
                    $('[data-toggle="tooltip"]').tooltip();
                    var table = $('#tablePrincipal').DataTable({
                        "language": {
                            "url": "vista/js/json/lenguaje.json"
                        },
                        responsive: true
                    });
                    new $.fn.dataTable.FixedHeader( table );
                })
            </script>
		<div class="panel-body">
            <table id="tablePrincipal" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    $data
                </tbody>
            </table>
            <button type='button' class='btn btn-success' onclick='menuA.generateForm("$titleID")' ><span class='glyphicon glyphicon-plus'></span> Agregar $title</button>
        </div>
    </div>    
EOT;
            return $varC;
        }
        function getFormRegistroGeneric($tipo, $data, $NivelDeAcceso,$dataExternal){
            $variableObsoleta = "";
            switch ($NivelDeAcceso){
                case 1:
                    $variableObsoleta = "";
                break;
                case 2:
                    $variableObsoleta = "<input type='hidden' value='_ID_USUARIO_' name='id_usuario' id='id_usuario' />";
                break;
            }
            $title = $NivelDeAcceso = 1? 'Registro':'Actualizar';
            $componentes_expertos = "<input type='hidden' name='extras' value='1' />";
            if($tipo==3){
                $cadenaCD = "";
                foreach ($dataExternal as $fila) {
                    $cadenaCD.= <<<EOT
                        <option value="{$fila['user_id']}">{$fila['firstname']} {$fila['lastname']}</option>    
EOT;
                }
                $componentes_expertos=<<<EOT
                <script>
                    $(()=>{    
                        $("select").multipleSelect({
                            filter: true,
                            position: 'top',
                            width: '100%'
                        });
                    });    
                </script>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="extras">Registro de RS</label>  
                    <div class="col-md-7">
                        <select multiple="multiple" id="extras" name="extras[]" data-validation="required">
                            $cadenaCD
                        </select>
                    <span class="help-block"></span>  
                   </div>
                </div>
EOT;
            }
            $nval =<<<EOT
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title panel-primary" id="myModalLabel">$title</h4>
                  </div>
                  <form action='#!' class="form-horizontal" id='registro_actualiza' role="form" data-toggle="validator" onsubmit="return false;">
                    <script src="vista/js/herr/admin/form.js"></script>
                  <div class="modal-body">
                  <fieldset>
                  <input type="hidden" value="$NivelDeAcceso" name="action" id="action" />
                  <input type="hidden" value="$tipo" name="tipo_usuario" id="tipo_usuario" />
                  $variableObsoleta
                  <!-- Form Name -->
                  
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="nombre">Nombre</label>  
                    <div class="col-md-7">
                    <input id="nombre" name="nombre" type="text" placeholder="Ingrese el nombre" data-minlength="3" class="form-control input-md" data-validation="required">
                    <span class="help-block"></span>  
                    </div>
                  </div>
                  
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="paterno">Apellidos</label>  
                    <div class="col-md-7">
                    <input id="paterno" name="paterno" type="text" placeholder="Ingrese sus apellidos" data-minlength="3" class="form-control input-md" data-validation="required">
                    <span class="help-block"></span>  
                    </div>
                  </div>
                  
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="username">Nombre de Usuario</label>  
                    <div class="col-md-7">
                    <input id="username" name="username" type="text" placeholder="Ingrese el nombre de usuario" data-minlength="8" class="form-control input-md" data-validation="required">
                    <span class="help-block"></span>  
                    </div>
                  </div>
                  
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="email">Correo de Usuario</label>  
                    <div class="col-md-7">
                    <input id="email" name="email" placeholder="Ingrese el email de usuario" class="form-control input-md" data-validation="required, email">
                    <span class="help-block"></span>  
                    </div>
                  </div>
                  
                  <!-- Password input-->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="contrasenia">Contraseña</label>
                    <div class="col-md-7">
                      <input id="contrasenia" name="contrasenia" data-minlength="8" type="password" placeholder="Ingrese una contraseña" class="form-control input-md" data-validation="required">
                      <span class="help-block"></span>
                    </div>
                  </div>
                    $componentes_expertos
                  </div>
                  <div class="modal-footer">
                  <!-- Button -->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="op">$title</label>
                    <div class="col-md-7">
                      <button id="op" name="op" class="btn btn-primary">$title</button>
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
    }
?>