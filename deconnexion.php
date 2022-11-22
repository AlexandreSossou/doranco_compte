<?php


require_once "inc/init.php";


if(isConnected){
unset($_SESSION['membre']); // pour enlever le membre de la session. 
}

header("location:connexion.php");
exit;