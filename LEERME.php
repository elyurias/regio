<?php
    /*
        Para poder subir imagenes al sistema, necesitas modificar la siguiente instruccion de
     * los archivos de configuracion de mysql, my.ini
     * 
     * innodb_log_file_size=256M
     * SET GLOBAL innodb_fast_shutdown = 1;
     * 
     * Reiniciar Servidor de MariaDB
     * 
     * se espera que las imagenes que se van a subir al sistema sean 3 veces mas pequeñas que el valor mas grande
     * encontrado... supongo que esto sera suficiente, si ocurre algun error, puede aumentar el tamaño.
     * 
     * Si vas a subirlo a sistemas linux, solo dale permisos de escritura a la carpeta /control/files
     *      */
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

