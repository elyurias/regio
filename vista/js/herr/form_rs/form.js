$(()=>{
    $.validate({
        lang: 'es'
    });
    $( "#registro_actualiza_actividad" ).submit(function( event ) {
        var type = BootstrapDialog.TYPE_DANGER;
        var mensajeEnComun =  "ERROR: PONGASE EN CONTACTO CON EL ADMINISTRADOR!!";
        var mensajePrincipal = mensajeEnComun;
        var title = mensajeEnComun;
        var labelData = mensajeEnComun;
        var operacion = mensajeEnComun;
        var icono = "glyphicon-remove";
        switch($("#action").val().trim()){
            case "Registrar Actividad":
                type = BootstrapDialog.TYPE_PRIMARY;
                title = "Agregar Nueva Actividad";
                labelData = "Insertar nueva Actividad";
                operacion = "Se ha registrado una nueva Actividad";
                icono = "glyphicon-eye-open";
            break;
            case "Actualizar Actividad":
                type = BootstrapDialog.TYPE_DANGER;
                title = "Realizar Cambios a la Actividad";
                labelData = "Actualizar la actividad";
                operacion = "La actividad se ha actualizado";
                icono = "glyphicon-modal-window";
            break;
        }
        mensajePrincipal = "Desea agregar una nueva actividad al usuario?";
        var moduleDir = function(dialog){
            menuC.callController(
                'control/rd.php',
                $("#registro_actualiza_actividad").serialize(),
                ()=>{},
                (data)=>{
                    console.log(data);
                    if(data.trim() == '-1'){
                        menuC.defin_msg_final('Error!',
                            'Operacion Fallida! No se puede insertar la actividad',
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }else if(data.trim() == '1'){
                        menuC.defin_msg_final('Aviso!',
                            operacion,
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close()
                        $('#myModal').modal('hide');
                    }else if(data.trim() == '-3'){
                        menuC.defin_msg_final('Aviso!',
                            "Un RS necesita estar registrado al RD para poder registrar la actividad",
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }
                    else{
                        menuC.defin_msg_final('WARNING!',
                            "ERROR FATAL: SYSTEM",
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close()
                    }
                }
            );
        };
        var buttons = [
            {
                label: labelData,
                icon: 'glyphicon '+icono,
                cssClass: 'btn-primary',
                action: function(dialog){
                    moduleDir(dialog);
                    menuC.getEventLineOperation();                    
                }
            }
        ];
        menuC.btn_config_data(
            buttons,
            mensajePrincipal,
            title,
            type
        );
        event.preventDefault();
    });
//    $('#username').keyup(()=>{
//        $('#username').val(constructLogic.getName())
//    })
});