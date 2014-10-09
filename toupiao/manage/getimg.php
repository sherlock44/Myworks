<?php
    header("content-type:image/jpg\r\n");

    $pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
    
    $id = $_GET['id'];

    if(!isset($id)) exit();

    $sql = "select * from hero where id=".$id;
    $data = $pdo->query($sql);
    while ($row = $data->fetchObject()) {
        $s = base64_decode(str_replace('data:image/jpeg;base64,', '', urldecode($row->headimg)));

        // var_dump(urldecode($row->headimg));

        // imagejpeg($s);
        // imagedestroy($s);

        echo $s;
    }
?>