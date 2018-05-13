$(()=>{
    $.validate({
        lang: 'es'
    });
    $( "#registro_actualiza" ).submit(function( event ) {
        var type = BootstrapDialog.TYPE_DANGER;
        var mensajeEnComun =  "ERROR: PONGASE EN CONTACTO CON EL ADMINISTRADOR!!";
        var mensajePrincipal = mensajeEnComun;
        var title = mensajeEnComun;
        var labelData = mensajeEnComun;
        var operacion = mensajeEnComun;
        var icono = "glyphicon-remove";
        switch($("#action").val().trim()){
            case "Registro":
                type = BootstrapDialog.TYPE_PRIMARY;
                title = "Agregar Nuevo Usuario";
                labelData = "Insertar Nuevo Usuario";
                operacion = "Se ha registrado un nuevo Usuario";
                icono = "glyphicon-eye-open";
            break;
            case "Actualizar":
                type = BootstrapDialog.TYPE_DANGER;
                title = "Realizar Cambios Al Usuario";
                labelData = "Actualizar al Usuario";
                operacion = "Usuario actualizado";
                icono = "glyphicon-modal-window";
            break;
        }
        mensajePrincipal = "Desea agregar al nuevo usuario?";
        var moduleDir = function(dialog){
            menuA.callController(
                'control/admin.php',
                $("#registro_actualiza").serialize(),
                ()=>{},
                (data)=>{
                    console.log(data);
                    if(data.trim() == '-1'){
                        menuA.defin_msg_final('Error!',
                            'Operacion Fallida! Nombre de Usuario o Correo Electronico, ya existen en el Sistema',
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }else if(data.trim() == '1'){
                        menuA.defin_msg_final('Aviso!',
                            operacion,
                            BootstrapDialog.TYPE_SUCCESS);
                        dialog.close()
                        $('#myModal').modal('hide');
                    }else if(data.trim() == '-3'){
                        menuA.defin_msg_final('Aviso!',
                            "Un RD necesita al menos un RS a la hora de Registrarse",
                            BootstrapDialog.TYPE_WARNING);
                        dialog.close()
                    }
                    else{
                        menuA.defin_msg_final('WARNING!',
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
                    menuA.getEventLineOperation();
                    
                }
            }
        ];
        menuA.btn_config_data(
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