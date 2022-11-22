<?php


require_once "inc/init.php";

//debug($_SESSION);


// ###### ETAPE 

//if(!empty($_POST)){
    if(isset($_POST['connexion'])){
    debug($_POST);


    // ETAPE de sécurisation des données
foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
}

    // Fin de sécurisatiion des données

    //ETAPE de vérification des données
    if (empty($_POST['username']) || empty($_POST['password'])){ {
        $errorMessage = 'les identifiants sont obligatoire';    
    }
    //Fin de vérification des données

}
    // Etape de connexion
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $errorMessage = 'les identifiants sont obligatoire';
    } else {

        $requete = $bdd->prepare("SELECT * FROM membre WHERE username = :username");
        $requete->execute([':username' => $_POST['username']]);

        //debug($requete->rowCount());// si le rowCount est = 1 alors là je vais récup mon user..

    if ($requete->rowCount()== 1){
        // pour aller chercher mon utilisateur ds l'objet et le stocké ds la variable user   
        $user = $requete->fetch();
        debug($user);
// pour vérifier son MDP // le MDP est hashé dc pr vérifier avec le formulaire j'utilise password_verify. 
        if (password_verify($_POST['password'], $user['password'])) {
            // une fois le MDP vérifié je le stock ds $user et il sera connecté.
            $_SESSION['membre'] = $user;

            $_SESSION['successMessage'] = "Bonjour $user[username], bienvenue sur votre compte";

            header("location:profil.php");
        exit; 

        }else{
            $errorMessage = "MDP ou identifiants incorrect";
        }

    }else{
        $errorMessage = "MDP ou identifiants incorrect";

}
    }

    // Fin de l'etape de connexion

    
        

};

debug($_SESSION);

require_once "inc/header.php";
?>




<h1 class="text-center">Connexion</h1>

<?php if (!empty($_SESSION['successMessage'])) { ?>
    <div class="alert alert-success col-md-6 text-center mx-auto">
        <?php echo $_SESSION['successMessage'] ?>
    </div>
    <?php unset($_SESSION['successMessage']); ?>
<?php } ?>

<?php if (!empty($errorMessage)) { ?>
    <div class="alert alert-danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>
    </div>
<?php } ?>

<form action="" method="post" class="col-md-6 mx-auto">

    <label for="username" class="form-label">Pseudo</label>
    <input type="text" placeholder="Votre Pseudo" name="username" id="username" class="form-control">

    <label for="password" class="form-label">Mot de Passe</label>
    <input type="password" placeholder="Votre Mot de Passe" name="password" id="password" class="form-control">

    <button class="d-block mx-auto btn btn-primary mt-3" name="connexion">Connexion</button>

</form>



<?php
require_once "inc/footer.php";