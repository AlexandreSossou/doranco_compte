<?php

// ###### Déclarer session ###### (obligatoire au début de notre site)

session_start();





try {
    
    $type_bdd = "mysql";
    $host = "localhost";
    $dbname = "php_compte";
    $username = "root";
    $password = "root";
    $options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //ici je defini
                 //que le mode de recup des données par défault est sous forme associative.   
];

    $bdd = new PDO("$type_bdd:host=$host;dbname=$dbname",$username,$password, $options);

} catch (Exception $e) {
    die ("ERREUR CONNEXION BDD: ".$e->getMessage());
}


// ###### Appel de mes functions #####

require_once "functions.php";   

// ###### declaration des variables globale
$errorMessage = "";
$successMessage = "";