<?php

    function AddLog($type, $user, $func, $description){
        try{
            $fname = 'log.txt';
            $file = fopen($fname, 'c');
            fseek($file, 0, SEEK_END);
            $line = '';
            $time = date("Y-m-d H:i:s");
            $type = $type == 0 ? 'ERROR' : 'OK';
            $line =  $time." | [".$type."] | ".$user." | ".$func." | ".$description;
            fwrite($file, PHP_EOL.$line);   
            fclose($file);
            return 1;
        }
        catch(Exception $e){
            return 0;
        }
    }

?>