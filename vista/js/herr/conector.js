class conector{
    callController($url, $json, proccess,endLoad){
        proccess();
        $.post(
            $url,
            $json,
            function(data){
                endLoad(data);
                return data;
            }
        ).done(function(data){
            return data;
        }).fail(function(data){
            return 0;
        });
    }
    btn_config_data($btns, $msg, $title, $type){
        BootstrapDialog.show({
            title: $title,
            message: $msg,
            type: $type,
            buttons: $btns
        });
    }
    defin_msg_final($title, $msg, $tipo){
        BootstrapDialog.show({
            title: $title,
            message: $msg,
            type: $tipo, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            callback: function(result) {
            }
        });
    }
}