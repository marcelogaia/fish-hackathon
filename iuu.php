<?php
    /*
     * Author: Ano Tisam
     * Date: 30/07/2016
     * Description: Convert IUU list at iuu-vessels.org into a JSON feed
    */
    require_once("common.php");

    error_reporting(0); if(function_exists('xdebug_disable')) { xdebug_disable(); }

    //Set search term
    (isset($_GET['search'])) ? $search = urlencode($_GET['search']) : $search = '';

    //Download IUU
    $iuuURL = 'http://iuu-vessels.org/iuu/php/showvessellist.php?searchTerm='. $search .'&ccamlr=true&seafo=true&nafo=true&iccat=true&neafc=true&iattc=true&iotc=true&wcpfc=true&sprfmo=true&interpol=true&live=true&delist=true&column=vessel_name&dir=asc&group=3';
    $returned_content = getIUUData($iuuURL); 

    // Do some spring cleaning on the table
    $returned_content = cleanIUUTable($returned_content); //print_r($returned_content);

    $iuuListArray = convertTableToArray($returned_content);
	
    //echo '<pre>';
    header('Content-Type: application/json');
	print_r(json_encode($iuuListArray));
    //echo '</pre>';

?>