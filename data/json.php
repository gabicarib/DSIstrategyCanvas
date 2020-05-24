<?php
    if(isset($_FILES['data'])){
        // read json file
        $data = file_get_contents($_FILES['data']['tmp_name']);
        echo $data;
     }
?>