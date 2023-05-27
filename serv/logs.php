<?php

    function AddLog($type, $user, $func, $description){
        try{
            $fname = 'log.txt';
            $file = fopen($fname, 'w');
            $line = '';
            $time = date("Y-m-d H:i:s");
            $type = $type == 0 ? 'ERROR' : 'OK';
            $line =  $time." | [".$type."] | ".$user." | ".$func." | ".$description."\n";
            fwrite($file, $line);
            return 1;
        }
        catch(Exception $e){
            return 0;
        }
    }
    
?>