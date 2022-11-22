<?php

function debug($value) {
    echo "<pre>"; 
        print_r($value);
    echo "</pre>";
}        

function isConnected($value):bool 
{
    return isset($_SESSION['membre']) ? TRUE : FALSE;
}