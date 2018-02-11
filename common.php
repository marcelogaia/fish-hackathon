<?php
    /*
     * Author: Ano Tisam
     * Date: 30/07/2016
     * Description: Convert IUU list at iuu-vessels.org into a JSON feed
    */
    
    /* Gets HTML from URL */
    function getIUUData($url) {
        $ch = curl_init();
        if (isset($proxy)) {                            // If the $proxy variable is set, then
            curl_setopt($ch, CURLOPT_PROXY, $proxy);    // Set CURLOPT_PROXY with proxy in $proxy variable
        }
        
        $timeout = 5;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        
        //sleep(rand(2, 3));        
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }

    /* IUU Table has issues, clean up those issues to make it easy to parse into PHP Array OR JSON */
    function cleanIUUTable($returned_content){

        $returned_content = str_replace('<td>3</td>','',$returned_content);    

        //Remove JS
        $dom = new DOMDocument;
        $dom->loadHTML(strip_tags($returned_content, "<table><tr><td><th>"));
        $nodes = $dom->getElementsByTagName('*');//just get all nodes, 

        foreach($nodes as $node)
        {
            if ($node->hasAttribute('onload'))
            {
                $node->removeAttribute('onload');
            }
            if ($node->hasAttribute('onclick'))
            {
                $node->removeAttribute('onclick');
            }
            if ($node->hasAttribute('href'))
            {
                $node->removeAttribute('href');
            }
            if ($node->hasAttribute('class'))
            {
                $node->removeAttribute('class');
            }
        }

        $returned_content = $dom->saveHTML();

        //Remove extra columns
        $returned_content = str_replace('<td>Details</td>','',$returned_content);
        $returned_content = str_replace('<th width="50px"></th>','',$returned_content);

        //Replace Empty Colunmns
        //$returned_content = str_replace('<td></td>','<td>Not Available</td>',$returned_content);    

        return $returned_content;
    }
    
    /* Convert IUU HTML Table to Array */
    function convertTableToArray($returned_content){
        $DOM = new DOMDocument();
        $aTempData = array();
        $aDataTableDetailHTML = array();
        
        // set error level
        $DOM->loadHTML($returned_content); //print_r($returned_content);
        if ($DOM->getElementsByTagName('table')){
            
            $Header = $DOM->getElementsByTagName('th');
            $Detail = $DOM->getElementsByTagName('td');

            //#Get header name of the table
            foreach($Header as $NodeHeader) 
            {
                $aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
            }
            //print_r($aDataTableHeaderHTML); die();

            //#Get row data/detail table without header name as key
            $i = 0;
            $j = 0;
            foreach($Detail as $sNodeDetail) 
            {
                $aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
                $i = $i + 1;
                $j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
            }
            //print_r($aDataTableDetailHTML); die();

            //#Get row data/detail table with header name as key and outer array index as row number            
            for($i = 0; $i < count($aDataTableDetailHTML); $i++)
            {
                for($j = 0; $j < count($aDataTableHeaderHTML); $j++)
                {
                    if (isset($aDataTableDetailHTML[$i][$j])) {                        
                        $aTempData[$i][$aDataTableHeaderHTML[$j]] = $aDataTableDetailHTML[$i][$j];
                    }
                    else
                        $aTempData = array('No Results' => 'Sorry! There are no records matching this criteria.');
                }
            }        
            

        }
        // Restore error level
        return $aTempData;
    }

    function searchArray($array, $key, $value){
        $results = array();

        if (is_array($array))
        {
            if (isset($array[$key]) && $array[$key] == $value)
                $results[] = $array;

            foreach ($array as $subarray)
                $results = array_merge($results, searchArray($subarray, $key, $value));
        }

        return $results;
    }
    
    /* Fuzzy Match */
    function fuzzy_match($query,$target,$distance) {
             ##  set max substitution steps if set to 0
             if ($distance == 0) {
                     $length = strlen($query);
                     if ($length > 10) {
                         $distance = 4;
                     }
                     elseif ($length > 6) {
                         $distance = 3;
                     }
                     else {
                         $distance = 2;
                     }
             }
             $lev = levenshtein(strtolower($query), strtolower($target));
             if ($lev <= $distance) {
                return array('match' => 1, 'distance' => $lev, 'max_distance' => $distance);
             }
             else {
                return array('match' => 0, 'distance' => $lev, 'max_distance' => $distance);
             }
    }

    function fuzzySearchArray($search, $iuuListArray, $key){
        $searchResult = array();
        $i = 0;
        foreach ($iuuListArray as $iuuList) {
            $matchingValues = fuzzy_match($search,$iuuList[$key],2);
            if ($matchingValues['match']){
                //$searchResult     = $iuuList;
                array_push($searchResult, $iuuList);
            }
            $i++;
        }
        return $searchResult;
    }
?>