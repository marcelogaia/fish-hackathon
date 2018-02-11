<?php  
    /*
     * Author: Ano Tisam
     * Date: 30/07/2016
     * Description: Convert IUU list scrapped from http://blacklist.greenpeace.org into a JSON feed. 
     *              Scrapped HTML is stored in /var/www/iuu/list by a shell script 
                   
                    ----------------------
                    Shell Script Below
                    ----------------------
                    #!/bin/sh

                    # a shell script used to download a greenpeace blacklist.
                    # this is executed from a crontab entry every day.

                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&gp_blacklist=1&startswith=A-D" -O /var/www/iuu/list/blacklist_gp_A-D.html 
                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&gp_blacklist=1&startswith=E-H" -O /var/www/iuu/list/blacklist_gp_E-H.html 
                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&startswith=I-L&gp_blacklist=1" -O /var/www/iuu/list/blacklist_gp_I-L.html 
                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&startswith=M-P&gp_blacklist=1" -O /var/www/iuu/list/blacklist_gp_M-P.html 
                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&startswith=Q-T&gp_blacklist=1" -O /var/www/iuu/list/blacklist_gp_Q-T.html 
                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&startswith=U-X&gp_blacklist=1" -O /var/www/iuu/list/blacklist_gp_U-X.html 
                    wget "http://blacklist.greenpeace.org/9/vessel/list?official_blacklist=1&startswith=Y-Z&gp_blacklist=1" -O /var/www/iuu/list/blacklist_gp_Y-Z.html 

                    echo "`date -u` `usr/local/bin/get_iuu`" >> /var/www/iuu/logfile.txt
    */
    require_once('vendor/autoload.php');
    require_once("common.php");
        
    //Set IUU URLs to Extract Tables as Arrays
    $iuuURLs = array(
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_A-D.html',
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_E-H.html',
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_I-L.html',
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_M-P.html',
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_Q-T.html',
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_U-X.html',
        'https://licensing.tklapp.com/iuu/list/blacklist_gp_Y-Z.html'/**/
    );
    $iuuListArray = array();

    //Get IUU Data and Convert to Array for each link, merge these togeather
    foreach ($iuuURLs as $iuuURL){
        $returned_content   = getIUUData($iuuURL); //print_r($returned_content);
        $tempIUU            = convertTableToArray($returned_content);
        $iuuListArray       = array_merge($iuuListArray, $tempIUU);
    }

    //If this is a search, search through the array for matches
    if (isset($_GET['search'])) {   
        $search = $_GET['search'];
        $key = 'Vessel name';
        $iuuListArray = fuzzySearchArray($search, $iuuListArray, $key);
    }    

    header('Content-Type: application/json');
    print_r(json_encode($iuuListArray));
?>