$(()=>{
    $.validate({
        lang: 'es'
    });
    $( "#registro_actualiza_actividad" ).submit(function(event) {
        event.preventDefault();
        var type = BootstrapDialog.TYPE_DANGER;
        var mensajeEnComun =  "ERROR: PONGASE EN CONTACTO CON EL ADMINISTRADOR!!";
        var mensajePrincipal = mensajeEnComun;
        var title = mensajeEnComun;
        var labelData = mensajeEnComun;
        var operacion = mensajeEnComun;
        var icono = "glyphicon-remove";
        switch($("#action").val().trim()){
            case "enviar":
                type = BootstrapDialog.TYPE_PRIMARY;
                title = "Enviar Evidencia de  Actividad";
                labelData = "Insertar evidencia Actividad";
                operacion = "Se ha enviado la evidencia de la Actividad";
                icono = "glyphicon-eye-open";
            break;
            case "actualizar":
                type = BootstrapDialog.TYPE_DANGER;
                title = "Realizar Cambios a la Actividad";
                labelData = "Actualizar la actividad";
                operacion = "La actividad se ha actualizado";
                icono = "glyphicon-modal-window";
            break;
        }
        mensajePrincipal = "Desea agregar una nueva actividad al usuario?";
        var moduleDir = function(dialog){
            /*var data = new FormData();
            data.append('foto1',document.getElementById('foto1').files[0]);
            data.append('foto2',document.getElementById('foto2').files[0]);
            data.append('action',$('#action').val());
            data.append('id_actividad',$('#id_actividad').val());
            */
            var file_data1 = $('#foto1').prop('files')[0];
            var file_data2 = $('#foto2').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', $('#action').val());
            form_data.append('id_actividad', $('#id_actividad').val());
            form_data.append('foto1', file_data1);
            form_data.append('foto2', file_data2);
            $.ajax({
                url: "control/rs.php",
                type: 'POST',
                data: form_data,
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                
                },
                success: function(data) {
                    console.log(data);
                    if(data.trim() == '-1'){
                        menuD.defin_msg_final('Error!',
                            'Operacion Fallida! No se puede enviar la evidencia de la actividad',
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }else if(data.trim() == '1'){
                        menuD.defin_msg_final('Aviso!',
                            operacion,
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close();
                        menuD.get_actividades(global_id_control);
                        $('#myModal').modal('hide');
                    }else if(data.trim() == '-7'){
                        menuD.defin_msg_final('Aviso!',
                            "El formato no es Compatible",
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }
                    else if(data.trim() == '-8'){
                        menuD.defin_msg_final('Aviso!',
                            "El fichero es muy grande para ser Procesado por el sistema",
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }
                    else{
                        menuD.defin_msg_final('WARNING!',
                            "ERROR FATAL: SYSTEM",
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close()
                    }
                },
                error: function(xhr, status, error){ 
                    alert(error);
                }
            });
            /*menuD.callController(
                'control/rs.php',
                $("#registro_actualiza_actividad").serialize(),
                ()=>{},
                (data)=>{
                    console.log(data);
                    if(data.trim() == '-1'){
                        menuD.defin_msg_final('Error!',
                            'Operacion Fallida! No se puede enviar la evidencia de la la actividad',
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }else if(data.trim() == '1'){
                        menuD.defin_msg_final('Aviso!',
                            operacion,
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close()
                        $('#myModal').modal('hide');
                    }else if(data.trim() == '-3'){
                        menuD.defin_msg_final('Aviso!',
                            "Un RS necesita estar registrado al RD para poder registrar la actividad",
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }
                    else{
                        menuD.defin_msg_final('WARNING!',
                            "ERROR FATAL: SYSTEM",
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close()
                    }
                }
            );*/
        };
        var buttons = [
            {
                label: labelData,
                icon: 'glyphicon '+icono,
                cssClass: 'btn-primary',
                action: function(dialog){
                    moduleDir(dialog);
                }
            }
        ];
        menuD.btn_config_data(
            buttons,
            mensajePrincipal,
            title,
            type
        );
    });
//    $('#username').keyup(()=>{
//        $('#username').val(constructLogic.getName())
//    })
});
