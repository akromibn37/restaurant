<?php

    function getDatabaseServerLocation()
    {
        return "localhost";
    }
    function getDatabaseUsername()
    {
        return "root";
    }
    function getDatabasePassword()
    {
        return "";
    }
    function getDatabaseName()
    {
        return "mk";
    }
    function createMysqlConnection()
    {
        $servername = getDatabaseServerLocation();
        $username = getDatabaseUsername();
        $password = getDatabasePassword();
        $dbname = getDatabaseName();
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->query('SET NAMES UTF8;');
        return $conn;
    }
    function createTable($sql)
    {
        $conn= createMysqlConnection();        
        $isSuccess = false;
        if ($conn->multi_query($sql) === TRUE)
        {
            $isSuccess = true;
        }
        else
        {
            echo "Error on create: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
        return $isSuccess;
    }
    
    //SHOW COLUMNS FROM products
    function showColumnFromTable($table_name)
    {
        $conn= createMysqlConnection();
        
        $sql = "SHOW FULL COLUMNS FROM $table_name";
        $result = $conn->query($sql);
        
        $columns = array();
        if ($result->num_rows > 0)
        {
            // output data of each row
            $i = 0;
            while($row = $result->fetch_assoc())
            {
                //Field	Type	Collation	Null	Key	Default	Extra	Privileges	Comment
                $columns_row = array(
                                       "column_index"=>$i                   ,
                                       "Field"=>$row["Field"]               ,
                                       "Type"=>$row["Type"]                 ,
                                       "Collation"=>$row["Collation"]       ,
                                       "Null"=>$row["Null"]                 ,
                                       "Key"=>$row["Key"]                   ,
                                       "Default"=>$row["Default"]           ,
                                       "Extra"=>$row["Extra"]               ,
                                       "Privileges"=>$row["Privileges"]     ,
                                       "Comment"=>$row["Comment"]           ,
                                       );
                array_push($columns,$columns_row);
                $i++;
            }
        } else {
            echo "0 results";
        }
        
        $conn->close();
        return   $columns;
    }

    function getTableNameFromFileContent($file_table)
    {
        $lines = explode("\n", $file_table );
        $table_name_temp = explode(" ", $lines[0]);
        $table_name_temp = $table_name_temp[count($table_name_temp)-1];
        $table_name = substr($table_name_temp,1,strlen($table_name_temp)-3);
        return $table_name;
    }
    function clear()
    {
        $structure = 'output/';
        $files = glob($structure."*"); // get all file names
        foreach($files as $file)
        { // iterate files
            if(is_file($file))
            {
                unlink($file); // delete file
            }
            if (is_dir($file))
            {
               rmdir($file);
            }
        }
        if (is_dir($structure))
        {
           rmdir($structure);
        }
        
        
    }
    
    function getPrimaryKey($columns)
    {
        for($i =0 ; $i < count($columns) ; $i ++)
        {
            if($columns[$i]["Key"] == "PRI")
            {
                return $columns[$i];
            }
        }
        return false;
    }
    
    
    
    function generateHelper($table_name,$columns,$file_name_generate)
    {
        $structure = 'output/';
        $template_dir = "template/";
        $file_template_name = $file_name_generate;
        $file_name = $table_name.$file_template_name ;
        
        $start_out_loop ="";
        $end_out_loop ="";
        $primary_column = getPrimaryKey($columns);
        if($primary_column === false)
        {
            echo "ERROR TABLE NO PRIMARY KEY!!!!!!!";
            return ;
        }
        if (!file_exists($structure))
        {
            if (!mkdir($structure, 0777, true))
            {
                die('Failed to create folders...');
            }
        }
        
        $toSearch = array("{{TABLE_NAME}}","{{DATABASE_SERVER_LOCATION}}"
                          ,"{{DATABASE_SERVER_USERNAME}}","{{DATABASE_SERVER_PASSWORD}}",
                          "{{DATABASE_NAME}}","{{TABLE_PRIMARY_KEY}}");
        $toReplace = array($table_name,getDatabaseServerLocation(),
                           getDatabaseUsername(),getDatabasePassword(),getDatabaseName(),$primary_column ["Field"]);
        
        //read template
        $template_content = file_get_contents($template_dir.$file_template_name)  or die("Unable to open file!");
        //prepare write file
        $file = fopen($structure .$file_name,"w")  or die("Unable to open file!");;
        //replace first step
        $template_content_out = str_replace($toSearch ,$toReplace ,$template_content);
        $txt = $template_content_out;
        
        //LOOP all columns 
        $START_LOOP_ALL_COLUMN_PATTERN = "{{##START LOOP ALL COLUMNS##}}";
        $END_LOOP_ALL_COLUMN_PATTERN =  "{{##END LOOP ALL COLUMNS##}}";
        $len_start_loop = strlen($START_LOOP_ALL_COLUMN_PATTERN);
        $len_end_loop = strlen($END_LOOP_ALL_COLUMN_PATTERN);
        $search_from = 0;
        while(true)
        {
            $pos_start = strpos($txt,$START_LOOP_ALL_COLUMN_PATTERN,$search_from);
            $pos_end = strpos($txt,$END_LOOP_ALL_COLUMN_PATTERN,$search_from);
            
            if($pos_start === false or $pos_end === false)
            {
                break;
            }
            $pattern_inner = substr($txt ,  $pos_start+$len_start_loop ,
                                    $pos_end - ($pos_start+$len_start_loop));
            $pattern_inner  =  trim($pattern_inner );
            //echo $pattern_inner."<br/>";
            ///////except list//////////
            $START_EXCEPT_LIST  = "{{EXCEPT LIST}}";
            $END_EXCEPT_LIST  = "{{END EXCEPT LIST}}";
            $len_START_EXCEPT_LIST = strlen($START_EXCEPT_LIST);
            $len_END_EXCEPT_LIST = strlen($END_EXCEPT_LIST);
            
            $pos_start_except_list =  strpos($pattern_inner, $START_EXCEPT_LIST);
            $pos_end_except_list =  strpos($pattern_inner, $END_EXCEPT_LIST);
            
            $except_list = array();
            if($pos_start_except_list !== false )
            {
                $temp_except_list = substr($pattern_inner , $pos_start_except_list  + $len_START_EXCEPT_LIST,
                                    $pos_end_except_list - ($pos_start_except_list  + $len_START_EXCEPT_LIST));   
                $except_list =  explode(",", $temp_except_list);
                
                $pattern_inner_temp = substr($pattern_inner,0,$pos_start_except_list);
                $pattern_inner_temp2 = substr($pattern_inner,$pos_end_except_list + $len_END_EXCEPT_LIST );
                $pattern_inner = $pattern_inner_temp . $pattern_inner_temp2;
            }
            ///////end except list//////////
            
            ////////SEPERATOR///////////
            
            $START_SEPERATOR  = "{{SEPERATOR}}";
            $END_SEPERATOR  = "{{END SEPERATOR}}";
            $len_START_SEPERATOR = strlen($START_SEPERATOR);
            $len_END_SEPERATOR  = strlen($END_SEPERATOR);
            
            $pos_start_sep =  strpos($pattern_inner, $START_SEPERATOR);
            $pos_end_sep =  strpos($pattern_inner, $END_SEPERATOR);
            
            $seperator = null;
            if($pos_start_sep !== false )
            {
                $temp_except_list = substr($pattern_inner , $pos_start_sep  + $len_START_SEPERATOR,
                                    $pos_end_sep - ($pos_start_sep  + $len_START_SEPERATOR));   
                $seperator =   $temp_except_list;
                echo "sep".$seperator."sep";
                $pattern_inner_temp = substr($pattern_inner,0,$pos_start_sep);
                $pattern_inner_temp2 = substr($pattern_inner,$pos_end_sep + $len_END_SEPERATOR );
                $pattern_inner = $pattern_inner_temp . $pattern_inner_temp2;
            }
            
            ////////END SEPERATOR///////////
            $output_loop = $start_out_loop;
            $isFirst_loop  = true;
            //echo "innerpattern[".$pattern_inner."]";
            $pattern_inner = trim($pattern_inner);
            //echo "innerpattern2[".$pattern_inner."]";
            for($i = 0; $i < count($columns ) ; $i ++)
            {
                //Field
                if(empty ($except_list) === false)
                {
                    if (in_array($columns[$i]["Field"], $except_list))
                    {
                        continue;
                    }
                }
                
                $column_type_small= "";
                if( strpos($columns[$i]["Type"], 'varchar') !== false ||
                    strpos($columns[$i]["Type"], 'text') !== false ||
                    strpos($columns[$i]["Type"], 'timestamp') !== false 
                   )
                {
                    $column_type_small = "s";
                }
                elseif( strpos($columns[$i]["Type"], 'int') !== false 
                   )
                {
                    $column_type_small = "i";
                }
                elseif( strpos($columns[$i]["Type"], 'double') !== false 
                   )
                {
                    $column_type_small = "d";
                }
                
                
                $toSearch = array("{{TABLE_NAME}}","{{COLUMN_FEILD}}","{{COLUMN_INDEX}}",
                                  "{{COLUMN_COMMENT}}","{{COLUMN_TYPE_SMALL}}");
                $toReplace = array($table_name,$columns[$i]["Field"],
                                   $columns[$i]["column_index"],$columns[$i]["Comment"],
                                   $column_type_small);
                if($seperator === null)
                {
                    $output_loop = $output_loop. "\n" .str_replace($toSearch ,$toReplace ,$pattern_inner);
                }
                else
                {
                    if($isFirst_loop )
                    {
                        $output_loop = $output_loop. "" .str_replace($toSearch ,$toReplace ,$pattern_inner);
                    }
                    else
                    {
                        $output_loop = $output_loop. $seperator .str_replace($toSearch ,$toReplace ,$pattern_inner);
                    }
                }
                echo "XX".$output_loop."XX";
                $isFirst_loop  = false;
            }
            $output_loop = $output_loop. $end_out_loop;
            $txt_start = substr($txt,0,$pos_start);
            $txt_end = substr($txt,$pos_end+$len_end_loop);
            $output_loop_2 = $txt_start.$output_loop.$txt_end;
            
            $lenOfNext = strlen($txt_start.$output_loop);
            $txt = $output_loop_2;
            
            $search_from = $lenOfNext;
            
            
        }
        
        
        
        
        
        fwrite($file, $txt);
        fclose($file);
    }
    
    ///////////////////////////////////////////////////////////////////////
    function generateCodeFileIndex($table_name,$columns )
    {
        $structure = 'output/';
        $template_dir = "template/";
        if (!file_exists($structure))
        {
            if (!mkdir($structure, 0777, true))
            {
                die('Failed to create folders...');
            }
        }
        
        $toSearch = array("{{TABLE_NAME}}");
        $toReplace = array($table_name);
        
        $template_content = file_get_contents($template_dir.'index.php')  or die("Unable to open file!");
        $file = fopen($structure ."index.php","w")  or die("Unable to open file!");;
        $template_content_out = str_replace($toSearch ,$toReplace ,$template_content);
        $txt = $template_content_out;
        fwrite($file, $txt);
        fclose($file);
        
    }
    function generateCodeFile_Insert_form($table_name,$columns )
    {
        $structure = 'output/';
        $template_dir = "template/";
        if (!file_exists($structure))
        {
            if (!mkdir($structure, 0777, true)) {
                die('Failed to create folders...');
            }
        }
        
        $file_name = '_insert_form.php';
        $toSearch = array("{{TABLE_NAME}}");
        $toReplace = array($table_name);
        
        $template_content = file_get_contents($template_dir.$file_name)  or die("Unable to open file!");
        $file = fopen($structure.$table_name .$file_name,"w")  or die("Unable to open file!");;
        $template_content_out = str_replace($toSearch ,$toReplace ,$template_content);
        $txt = $template_content_out;
        
        $START_LOOP_ALL_COLUMN_PATTERN = "{{##START LOOP ALL COLUMNS##}}";
        $END_LOOP_ALL_COLUMN_PATTERN =  "{{##END LOOP ALL COLUMNS##}}";
        $len_start_loop = strlen($START_LOOP_ALL_COLUMN_PATTERN);
        $len_end_loop = strlen($END_LOOP_ALL_COLUMN_PATTERN);
        $search_from = 0;
        while(true)
        {
            $pos_start = strpos($txt,$START_LOOP_ALL_COLUMN_PATTERN,$search_from);
            $pos_end = strpos($txt,$END_LOOP_ALL_COLUMN_PATTERN,$search_from);
            
            if($pos_start === false or $pos_end === false)
            {
                break;
            }
            $pattern_inner = substr($txt ,  $pos_start+$len_start_loop ,
                                    $pos_end - ($pos_start+$len_start_loop));
            
            //echo $pattern_inner."<br/>";
            ///////except list//////////
            $START_EXCEPT_LIST  = "{{EXCEPT LIST}}";
            $END_EXCEPT_LIST  = "{{END EXCEPT LIST}}";
            $len_START_EXCEPT_LIST = strlen($START_EXCEPT_LIST);
            $len_END_EXCEPT_LIST = strlen($END_EXCEPT_LIST);
            
            $pos_start_except_list =  strpos($pattern_inner, $START_EXCEPT_LIST);
            $pos_end_except_list =  strpos($pattern_inner, $END_EXCEPT_LIST);
            
            $except_list = array();
            if($pos_start_except_list !== false )
            {
                $temp_except_list = substr($pattern_inner , $pos_start_except_list  + $len_START_EXCEPT_LIST,
                                    $pos_end_except_list - ($pos_start_except_list  + $len_START_EXCEPT_LIST));   
                $except_list =  explode(",", $temp_except_list);
                
                $pattern_inner_temp = substr($pattern_inner,0,$pos_start_except_list);
                $pattern_inner_temp2 = substr($pattern_inner,$pos_end_except_list + $len_END_EXCEPT_LIST );
                $pattern_inner = $pattern_inner_temp . $pattern_inner_temp2;
            }
            ///////end except list//////////
            $output_loop = "\n\n";
            for($i = 0; $i < count($columns ) ; $i ++)
            {
                //Field
                if(empty ($except_list) === false)
                {
                    if (in_array($columns[$i]["Field"], $except_list))
                    {
                        continue;
                    }
                }
                $toSearch = array("{{TABLE_NAME}}","{{COLUMN_FEILD}}","{{COLUMN_INDEX}}","{{COLUMN_COMMENT}}");
                $toReplace = array($table_name,$columns[$i]["Field"],
                                   $columns[$i]["column_index"],$columns[$i]["Comment"]);

                $output_loop = $output_loop. "\n" .str_replace($toSearch ,$toReplace ,$pattern_inner);
            }
            $output_loop = $output_loop. "\n";
            $txt_start = substr($txt,0,$pos_start);
            $txt_end = substr($txt,$pos_end+$len_end_loop);
            $output_loop_2 = $txt_start.$output_loop.$txt_end;
            
            $lenOfNext = strlen($txt_start.$output_loop);
            $txt = $output_loop_2;
            
            $search_from = $lenOfNext;
            
            
        }
        
        
        
        
        
        fwrite($file, $txt);
        fclose($file);
        
    }
    function generateCodeFileFunction($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_function.php');
    }
    function generateCodeFileDelete($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_delete.php');
    }
    function generateCodeFileInsert_action($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_insert_action.php');
    }
    function generateCodeFileSearch($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_search.php');
    }
    function generateCodeFileShow_all_table($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_show_all_table.php');
    } 
    function generateCodeFileShow_all($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_show_all.php');
    }
    function generateCodeFileUpdate_action($table_name,$columns )
    {
        generateHelper($table_name,$columns,'_update_action.php');
    }
    function copyJquery( )
    {
        $input  = "template/jquery-2.1.3.min.js";
        $output = "output/jquery-2.1.3.min.js";
        if (!copy($input, $output))
        {
            echo "!!!ERROR!!! failed to copy $input...\n";
        }
    }
    /////////////////
    $file_table = file_get_contents('table.txt')  or die("Unable to open file!");

    $table_name = getTableNameFromFileContent($file_table);
    echo $table_name;
    
    createTable($file_table);
    $columns = showColumnFromTable($table_name);
    ////////////////////////
    clear();
    generateCodeFileIndex($table_name,$columns );
    
    generateCodeFile_Insert_form($table_name,$columns );
    
    generateCodeFileFunction($table_name,$columns );
    generateCodeFileDelete($table_name,$columns );
    generateCodeFileInsert_action($table_name,$columns );
    generateCodeFileSearch($table_name,$columns );
    generateCodeFileShow_all_table($table_name,$columns );
    generateCodeFileShow_all($table_name,$columns );
    generateCodeFileUpdate_action($table_name,$columns );
    copyJquery( );
    print_r($columns);
    
    
    
    for($i = 0 ; $i < count($columns ) ; $i ++)
    {
        echo $columns[$i]["Field"]."<br/>";
    }

?>