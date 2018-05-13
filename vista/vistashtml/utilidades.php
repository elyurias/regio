<?php
class utilidades{
    function getTablaScript($id): String{
            return <<<EOT
            <script>
                $(()=>{
                    $('[data-toggle="tooltip"]').tooltip();
                    var tableLN = $('#$id').DataTable({
                        "language": {
                            "url": "vista/js/json/lenguaje.json"
                        },
                        responsive: true
                    });
                    new $.fn.dataTable.FixedHeader( tableLN );
                })
            </script>
EOT;
    }
    function thead($array,$id): String{
        $cadena = '<thead><tr>';
        for ($i = 0; $i < SIZEOF($array); $i++) {
            $cadena.= <<<EOT
                   <th>
                        {$array[$i]}
                   </th>
EOT;
        }
        $cadena.="</tr></thead>";
        return $cadena;
    }
    function table($script, $id, $thead, $tbody): String{
        return $script.'<table id="'.$id.'" class="table table-striped table-bordered nowrap" style="width:100%">'
                .$thead.$tbody.'</table>';
    }
}
