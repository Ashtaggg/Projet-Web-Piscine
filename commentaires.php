<?php
    echo"sjhvskvnj";
    if (isset($_POST["IDpostCom"]) && !(empty($_POST['IDpostCom']))) {
        $IDpostCom = isset($_POST['IDpostCom']) ? $_POST['IDpostCom'] : "";
        echo"</br>eiv n lbin" . $IDpostCom;
        
        /*
        $com = "SELECT * FROM post WHERE IDpost LIKE '%$IDpostCom%'";
        $com_result = mysqli_query($db_handle,$com);
        $com_data = mysqli_fetch_assoc($com_result);
        
        $Com = $com_data["Commentaires"] + 1;
        
        $sql = "UPDATE post SET Commentaires = $Com WHERE IDpost = {$IDpostCom}";

        $result2 = mysqli_query($db_handle, $sql);*/
    } 
?>