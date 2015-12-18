<?php

function rebuild_array($array) {
    $newarray = array();
    foreach ($array as $key => $value) {
        $newarray[$key] = $value['title'];
    }
?>